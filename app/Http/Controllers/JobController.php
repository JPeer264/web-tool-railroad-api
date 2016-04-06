<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Job;

class JobController extends Controller
{
    /**
     * should get one specific job by id
     *
     * @return 200 {Object} - a json with one job
     * @return 404 - job not found
     */
    public function get(Request $request, $id) {
        // todo janpeer check if filter isset and apply
        // todo janpeer get information from DB 

        $err = false;

        if($err) {
            abort(404, 'company not found');
        }

        $return = ['id' => '1', 'name' => 'testjob'];

        return response()->json($return);
    }

    /**
     * should get every job
     *
     * can be filtered by one or more companies
     *
     * @return 200 {Array} - within this array several single objects as job
     * @return 404 - no jobs found
     */
    public function getAll(Request $request) {
        // todo janpeer check if filter isset and apply
        // todo janpeer check for error 409

        $return = [(object)['id' => '1', 'name' => 'testjob'], (object)['id' => '2', 'name' => 'testjob']];

        return response()->json($return);
    }

    /**
     * should create a new job
     *
     * @return 200 - job successfully created
     * @return 409 - job already exists
     */
    public function create(Request $request) {
        // todo janpeer create a job with given information using $response()->all();

        $err = false;

        if($err) {
            abort(409, 'job already exists');
        }

        return; // returns 200
    }

    /**
     * updates a specific job by id
     *
     * @return 200 - successfully updated
     * @return 404 - job does not exist
    */
    public function update(Request $request, $id) {
        // todo janpeer update the job information using $response()->all();
        // todo janpeer check for error 404

        $err = false;

        if($err) {
            abort(404, 'job does not exists');
        }

        return; // returns 200
    }

    /**
     * deletes a specific job by id
     *
     * @return 200 - successfully deleted
     * @return 404 - job does not exist 
     */
    public function delete(Request $request, $id) {
        // todo janpeer delete the job
        // todo janpeer check for error 404

        $err = false;

        if($err) {
            abort(404, 'job does not exists');
        }

        return; // returns 200
    }
}
