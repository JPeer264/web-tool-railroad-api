<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category;
use App\Http\Controllers\Filter;
use App\Job;

class CategoryController extends Controller
{
    /**
     * should get one specific category by id
     *
     * @return 200 {Object} - a json with one category
     * @return 404 - category not found
     */
    public function get(Request $request, $id) {
        $categories = Category::with('topic')->find($id);

        if (empty($categories)) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);          
        }

        return response()->json($categories->toArray());
    }

    /**
     * should get every category
     *
     * can be filtered by one or more jobs, companies and limit_topics
     *
     * @return 200 {Array} - within this array several single objects as category
     */
    public function getAll(Request $request) {
        $categories = Category::with('topic', 'job', 'company')->get();
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
        $params = $request->all();
        $exist = Category::with('job', 'company')
            ->where('title', $params['title'])
            ->get();
        $existfilter = new Filter($exist, $params);    
        $existfilter
            ->byUsedPivots('company')
            ->byUsedPivots('job');

        // check if there are name duplicates in job or company
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
        // todo update pivottables
        $params = $request->all();

        // filter parameters for update pivot
        $categorypivot = Category::with('job', 'company')->where('id', $id)->get();
        $filterpivot = new Filter($categorypivot, $params);
        $pivotparams = $filterpivot
            ->updatePivot('job')
            ->updatePivot('company')
            ->globalParameters;

        // exist filter
        // todo exlcude itself from search
        $exist = Category::with('job', 'company')
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

        // todo delete pivots
        $filter
            ->saveToPivot('job')
            ->saveToPivot('company');

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
    public function delete(Request $request, $id) {
        // todo janpeer delete the category
        // todo janpeer check for error 404
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
