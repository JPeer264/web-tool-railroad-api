<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Category;
use App\Http\Controllers\Filter;

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
        $params = $request->all();
        $filter = new Filter();

        // filter by given parameters 
        $companyFilter  = $filter->byParameters($categories, $params, 'company');
        $jobFilter      = $filter->byParameters($companyFilter, $params, 'job');

        return response()->json($jobFilter->toArray());
    }

    /**
     * should create a new category
     *
     * @return 200 - category successfully created
     * @return 409 - category already exists
     */
    public function create(Request $request) {
        // todo janpeer create a category with given information using $response()->all();

        $err = false;

        if($err) {
            abort(409, 'category already exists');
        }

        return; // returns 200
    }

    /**
     * updates a specific category by id
     *
     * @return 200 - successfully updated
     * @return 404 - category does not exist
    */
    public function update(Request $request, $id) {
        // todo janpeer update the category information using $response()->all();
        // todo janpeer check for error 404

        $err = false;

        if($err) {
            abort(404, 'category does not exists');
        }

        return; // returns 200
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

        $err = false;

        if($err) {
            abort(404, 'category does not exists');
        }

        return; // returns 200
    }
}
