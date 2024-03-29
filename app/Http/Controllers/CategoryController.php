<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Category;
use App\Topic;
use App\Http\Controllers\Filter;

class CategoryController extends Controller
{

    /**
     * @var JWTAuth
     */
    private $auth;

    /**
     * @param JWTAuth $auth
     */
    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    /**
     * should get one specific category by id
     *
     * @return 200 {Object} - a json with one category
     * @return 404 - category not found
     */
    public function get(Request $request, $id) {

        $categories = Category::with('subcategory')->find($id);

        if (empty($categories)) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json($categories);
    }

    /**
     * should get every category with subcategories
     *
     * @return 200 {Array} - within this array several single objects as category
     */
    public function getAll(Request $request) {
        $user = $this->auth->user();

        // todo every user still see all topiccounts...
        $categories = Category::with(['subcategory' => function ($q) {
                $q->select('id', 'title', 'category_id')
                    ->with(['topic' => function ($q) {
                        $q->with(['comment' => function ($q) {
                            $q->select('id', 'content', 'user_id', 'topic_id', 'created_at')
                                ->orderBy('created_at', 'desc')
                                ->with(['user' => function ($q) {
                                    $q->select('id', 'firstname', 'lastname');
                                }])
                                ->with(['topic' => function ($q) {
                                    $q->select('id', 'title', 'type_id', 'user_id')
                                        ->with('type');
                                }]);
                        }])
                        ->with('job', 'company')
                        ->with(['user' => function ($q) {
                            $q->select('id', 'firstname', 'lastname');
                        }]);
                    }]);
            }])
            ->select('id', 'title')
            ->get();

        // adds lates_comment
        foreach ($categories as $categoryKey => $category) {
            foreach ($category->subcategory as $subcategoryKey => $subcategory) {
                // filter the latest comment per topic
                foreach ($subcategory['topic'] as $topicKey => $topic) {
                    // todo delete topics not shown topics for normal users
                    // todo shown for all admins < 4

                    if ($user->role_id >= 4) {
                        $isCompanyFilterSet = false;
                        $isJobFilterSet = false;
                        $isInCompany = false;
                        $isInJob = false;

                        if (isset($topic['company'][0])) {
                            $isCompanyFilterSet = true;

                            foreach ($topic['company'] as $company) {
                                if ($company->id == $user->company_id) {
                                    $isInCompany = true;
                                }
                            }
                        }

                        if (isset($topic['job'][0])) {
                            $isJobFilterSet = true;

                            foreach ($topic['job'] as $job) {
                                if ($job->id == $user->job_id) {
                                    $isInJob = true;
                                }
                            }
                        }

                        // if both filter are set
                        if ($isCompanyFilterSet && $isJobFilterSet) {
                            if (!$isInJob || !$isInCompany) {
                                unset($subcategory['topic'][$topicKey]);
                            }
                        }

                        // if just company filter isset
                        if ($isCompanyFilterSet && !$isJobFilterSet) {
                            if (!$isInCompany) {
                                unset($subcategory['topic'][$topicKey]);
                            }
                        }

                        // if just job filter isset
                        if (!$isCompanyFilterSet && $isJobFilterSet) {
                            if (!$isInJob) {
                                unset($subcategory['topic'][$topicKey]);
                            }
                        }
                    }
                }
                // get topic count of each subcategory
                $subcategory->topic_count = count($subcategory->topic);

                // cache previous comment
                $cachedComment = null;

                // keep the first comment
                foreach ($subcategory->topic as $topic) {
                    if (isset($topic->comment[0])) {

                        foreach ($topic->comment as $commentKey => $comment) {
                            $currentCreatedAt = $comment->created_at;

                            // set first cached previous date
                            if (!isset($cachedComment)) {
                                $cachedComment = $comment;
                            }

                            if ($currentCreatedAt->gt($cachedComment->created_at)) {
                                $cachedComment = $comment;
                            }
                        }
                    }
                }

                $subcategory->latest_comment = $cachedComment;

                if (count($subcategory->latest_comment) == 0) {
                    // cache previous topic
                    $cachedTopic = null;

                    foreach ($subcategory->topic as $topic) {
                        $currentCreatedAt = $topic->created_at;

                        if (!isset($cachedTopic)) {
                            $cachedTopic = $topic;
                        }

                        if ($currentCreatedAt->gt($cachedTopic->created_at)) {
                            $cachedTopic = $topic;
                        }
                    }

                    unset($subcategory->latest_comment);
                    unset($cachedTopic->company);
                    unset($cachedTopic->job);
                    unset($cachedTopic->comment);
                    $subcategory->latest_topic = $cachedTopic;
                }

                unset($category->subcategory[$subcategoryKey]->topic);
            } // end foreach $category->subcategory
        } // end foreach $categories

        return response()->json($categories->toArray());
    }

    /**
     * should create a new category, but fails if a name is duplicated
     *
     * @return 201 - category successfully created
     * @return 409 - category already exists
     */
    public function create(Request $request) {

        // todo check if it is a superadmin (1)
        $this->validate($request, [
           'title' => 'required|string',
        ]);

        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to update categories.'
                ], 401);
        }

        $exist = Category::where('title', $params['title'])->get();

        if (!count($exist->toArray()) == 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409);
        }

        $categories = Category::create($params);

        return response()->json([
                'message' => 'Category successfully created',
                'category_id' => $categories->id
            ], 201);
    }

    /**
     * updates a specific category by id
     *
     * @return 200 - successfully updated
     * @return 404 - category does not exist
     * @return 409 - category already exist
    */
    public function update(Request $request, $id) {

        // todo check if it is a superadmin (1)
        $this->validate($request, [
           'title' => 'required|string',
        ]);

        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to update categories.'
                ], 401);
        }

        $category = Category::find($id);
        $exist = Category::
            where('title', $params['title'])
            ->where('id', '!=', $id)
            ->get();

        if ($category == NULL) {
            return response()->json([
                'message' => 'Category does not exist',
            ], 404);
        }

        if (!count($exist->toArray()) == 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409);
        }

        $update = $category->update($params);

        return response()->json([
                'message' => 'Category successfully updated',
            ], 200);
    }

    /**
     * deletes a specific category by id
     *
     * @return 200 - successfully deleted
     * @return 404 - category does not exist
     */
    public function delete($id) {
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to delete categories.'
                ], 401);
        }

        $category = Category::find($id);

        if ($category == NULL) {
            return response()->json([
                'message' => 'Category does not exist',
            ], 404);
        }

        $category->delete();

        return response()->json([
                'message' => 'Category successfully deleted',
            ], 200);
    }
}
