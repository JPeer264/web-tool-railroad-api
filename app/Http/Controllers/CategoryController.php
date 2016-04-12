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
        // todo validation
        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        $categories = Category::where('id', $id)->get();
        $topicController = new TopicController($this->auth);
        $topics = $topicController
            ->getAllByCategoryLessInformation($request, $id)
            ->getData();

        // check if user is normal user or companyadmin and 
        // change to his own company and job
        if ($user->role_id > 3) {
            $params['job'] = array($user->job_id);
            $params['company'] = array($user->company_id);
        }

        // filter by given parameters 
        $filter = new Filter($categories, $params);
        $filtered = $filter
            ->byParameters('company')
            ->byParameters('job');

        if (empty($categories)) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);          
        }

        // to array before foreach
        $categories = $filtered->getArray();

        foreach ($categories as $key => $value) {
            foreach ($topics as $topic) {

                if ($value == $topic->category_id) {
                    $categories['topics'][] = $topic;
                }
            }
        }

        return response()->json($categories);
    }

    /**
     * should get every category
     *
     * can be filtered by one or more jobs, companies and limit_topics
     *
     * @return 200 {Array} - within this array several single objects as category
     */
    public function getAll(Request $request) {
        // todo validation
        // todo show topics - not shown because of filtering problems
        $categories = Category::with('job', 'company')->get();
        $user = $this->auth->parseToken()->authenticate();

        // check if user is normal user or companyadmin and 
        // change to his own company and job
        if ($user->role_id > 2) {
            // normal user
            $params['job'] = array($user->job_id);
            $params['company'] = array($user->company_id);
        }

        $filter = new Filter($categories, $request->all());

        // filter by given parameters 
        $filtered  = $filter
            ->byParameters('company')
            ->byParameters('job');

        return response()->json($filtered->getArray());
    }

    /**
     * should create a new category, but fails if a name is duplicated
     *
     * @return 201 - category successfully created
     * @return 409 - category already exists
     */
    public function create(Request $request) {
        // todo validation
        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();
        $exist = Category::with('job', 'company')
            ->where('title', $params['title'])
            ->get();

        if ($user->role_id == 4) {
            // normal user
            return response()->json([
                    'message' => 'You cannot add a new category as a normal user'
                ], 401); 
        } else if ($user->role_id == 3) {
            // company admin can create categories
            // but just for his own company
            $params['company'] = array($user->company_id);
        }

        $existfilter = new Filter($exist, $params);    
        $existfilter
            ->byUsedPivots('company')
            ->byUsedPivots('job');

        // checks if there are name duplicates in job or company
        if ($existfilter->isUsedByPivots()) {
            // if there are already used filters in pivots
            $existIn = $existfilter
                ->getUsedPivots('company')
                ->getUsedPivots('job')
                ->usedPivots;

            return response()->json([
                'message' => 'Categoryname already exist in the listed job or company',
                'existIn' => $existIn
            ], 409); 

        } else if (count($exist) != 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409); 
        }

        $categories = Category::create($params);
        $categoriesfilter = new Filter($categories, $params);
        // save into necessary pivottables if no error
        $categoriesfilter
            ->saveToPivot('job')
            ->saveToPivot('company');

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
        // todo validation
        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        if ($user->role_id == 4) {
            // normal user
            return response()->json([
                    'message' => 'You cannot update a category as a normal user'
                ], 401); 
        } else if ($user->role_id == 3) {
            // company admin can create categories
            // but just for his own company
            // let array blank that company does not update
            $params['company'] = array();
        }

        // filter parameters for update pivot
        $categorypivot = Category::with('job', 'company')
            ->where('id', $id)
            ->get();
        $filterpivot = new Filter($categorypivot, $params);
        $pivotparams = $filterpivot
            ->prepareParameterForPivotUpdate('job')
            ->prepareParameterForPivotUpdate('company')
            ->globalParameters;

        // exist filter
        $exist = Category::with('job', 'company')
            ->where('id','!=', $id)
            ->where('title', $params['title'])
            ->get();
        $existfilter = new Filter($exist, $params);    
        $existfilter
            ->byUsedPivots('company')
            ->byUsedPivots('job');

        // filter for updating
        $category = Category::find($id);
        $filter = new Filter($category, $pivotparams);

        if ($category == NULL) {
            return response()->json([
                'message' => 'Category does not exist',
            ], 404);
        }

        if ($existfilter->isUsedByPivots()) {
            // if there are already used filters in pivots
            $existIn = $existfilter
                ->getUsedPivots('company')
                ->getUsedPivots('job')
                ->usedPivots;

            return response()->json([
                'message' => 'Categoryname already exist in the listed job or company',
                'existIn' => $existIn
            ], 409); 

        } else if (count($exist) != 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409); 
        }

        $filter
            ->updatePivot('job')
            ->updatePivot('company');

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
        if ($user->role_id > 2) {
            // admins only
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
