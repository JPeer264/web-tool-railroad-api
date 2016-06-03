<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Subcategory;

class SubcategoryController extends Controller
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
     * should get one specific subcategory by id
     *
     * @return 200 {Object} - a json with one subcategory
     * @return 404 - subcategory not found
     */
    public function get(Request $request, $id) {
        $user = $this->auth->user();

        // get topics with their comment and user
        // comments are sorted by created_at desc
        $subcategory = Subcategory::with('category')
            ->with(['topic' => function ($q) {
                $q->select('id', 'title', 'subcategory_id', 'user_id', 'type_id', 'created_at')
                    ->with(['comment' => function ($q) {
                        $q->select('id', 'user_id', 'topic_id')
                            ->orderBy('created_at', 'desc')
                            ->with(['user' => function ($q) {
                                $q->select('id', 'firstname', 'lastname', 'picture_location');
                            }]);
                    }])
                    ->with(['user' => function ($q) {
                        $q->select('id', 'firstname', 'lastname');
                    }])
                    ->with('job', 'company');
            }])
            ->find($id);

        // filter the latest comment per topic
        foreach ($subcategory['topic'] as $topicKey => $topic) {
            // todo delete topics not shown topics for normal users
            // todo shown for all admins < 4

            if (isset($topic['comment'][0])) {
                $comment = $topic['comment'][0];

                // regenerate object
                $topic['latest_comment'] = $comment;

                // clear object
                unset($topic['comment']);
            } else {
                unset($topic['comment']);
            }

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
                    if ($isInJob || $isInCompany) {
                        unset($subcategory['topic'][$topicKey]);
                    }
                }

                // if just company filter isset
                if ($isCompanyFilterSet && !$isJobFilterSet) {
                    if ($isInCompany) {
                        unset($subcategory['topic'][$topicKey]);
                    }
                }

                // if just job filter isset
                if (!$isCompanyFilterSet && $isJobFilterSet) {
                    if ($isInJob) {
                        unset($subcategory['topic'][$topicKey]);
                    }
                }
            }
        }

        unset($subcategory->deleted_at);

        if (empty($subcategory)) {
            return response()->json([
                'message' => 'Subcategory not found',
            ], 404);
        }

        return response()->json($subcategory);
    }

    /**
     * should get every subcategory with subsubcategories
     *
     * @return 200 {Array} - within this array several single objects as subcategory
     */
    public function getAll(Request $request) {

        $subcategories = Subcategory::with('category')->get();

        return response()->json($subcategories->toArray());
    }

    /**
     * should create a new subcategory, but fails if a name is duplicated
     *
     * @return 201 - subcategory successfully created
     * @return 409 - subcategory already exists
     */
    public function create(Request $request, $category_id) {

        // todo check if it is a superadmin (1)
        $this->validate($request, [
           'title' => 'required|string|unique:type',
        ]);

        $params = $request->all();
        $params['category_id'] = $category_id;
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to update subcategories.'
                ], 401);
        }

        $exist = Subcategory::where('title', $params['title'])->get();

        if (!count($exist->toArray()) == 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409);
        }

        $subcategories = Subcategory::create($params);

        return response()->json([
                'message' => 'Subcategory successfully created',
                'category_id' => $subcategories->id
            ], 201);
    }

    /**
     * updates a specific subcategory by id
     *
     * @return 200 - successfully updated
     * @return 404 - subcategory does not exist
     * @return 409 - subcategory already exist
    */
    public function update(Request $request, $id) {

        // todo check if it is a superadmin (1)
        $this->validate($request, [
           'title' => 'required|string|unique:type',
        ]);

        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to update subcategories.'
                ], 401);
        }

        $subcategory = Subcategory::find($id);
        $exist = Subcategory::
            where('title', $params['title'])
            ->where('id', '!=', $id)
            ->get();

        if ($subcategory == NULL) {
            return response()->json([
                'message' => 'Subcategory does not exist',
            ], 404);
        }

        if (!count($exist->toArray()) == 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409);
        }

        $update = $subcategory->update($params);

        return response()->json([
                'message' => 'Subcategory successfully updated',
            ], 200);
    }

    /**
     * deletes a specific subcategory by id
     *
     * @return 200 - successfully deleted
     * @return 404 - subcategory does not exist
     */
    public function delete($id) {
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to delete subcategories.'
                ], 401);
        }

        $subcategory = Subcategory::find($id);

        if ($subcategory == NULL) {
            return response()->json([
                'message' => 'Subcategory does not exist',
            ], 404);
        }

        $subcategory->delete();

        return response()->json([
                'message' => 'Subcategory successfully deleted',
            ], 200);
    }
}
