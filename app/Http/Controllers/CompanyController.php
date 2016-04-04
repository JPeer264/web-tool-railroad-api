<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /**
     * should get one specific category by id
     *
     * @return 200 {Object} - a json with one category
     * @return 404 - company not found
     */
    public function get(Request $request, $id) {
        // todo janpeer check if filter isset and apply
        // todo janpeer get information from DB 

        $err = false;

        if($err) {
            abort(404, 'company not found');
        }

        $return = ['id' => '1', 'name' => 'testcompany'];

        return response()->json($return);
    }

    /**
     * should get every company
     *
     * can be filtered by one or more jobs and countries
     *
     * @return 200 {Array} - within this array several single objects as company
     */
    public function getAll(Request $request) {
        // todo janpeer check if filter isset and apply
        // todo janpeer check for error 409

        $return = [(object)['id' => '1', 'name' => 'testcompany'], (object)['id' => '2', 'name' => 'testcompany']];

        return response()->json($return);
    }

    /**
     * should create a new company
     *
     * @return 200 - company successfully created
     * @return 409 - company already exists
     */
    public function create(Request $request) {
        // todo janpeer create a company with given information using $response()->all();

        $err = false;

        if($err) {
            abort(409, 'company already exists');
        }

        return; // returns 200
    }

    /**
     * updates a specific company by id
     *
     * @return 200 - successfully updated
     * @return 404 - company does not exist
    */
    public function update(Request $request, $id) {
        // todo janpeer update the company information using $response()->all();
        // todo janpeer check for error 404

        $err = false;

        if($err) {
            abort(404, 'company does not exists');
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
