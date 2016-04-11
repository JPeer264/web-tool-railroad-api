<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Job;
use App\Company;
use App\Http\Controllers\Filter;

class JobController extends Controller
{
    /**
     * should get one specific job by id
     *
     * @return 200 {Object} - a json with one job
     * @return 404 - job not found
     */
    public function get(Request $request, $id) {
        // todo validation
        $job = Job::find($id);

        if (empty($job)) {
            return response()->json([
                'message' => 'Job not found',
            ], 404);          
        }

        return response()->json($job->toArray());
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
        // todo validation
        // todo check for company filter
        $jobs = Job::get();

        return response()->json($jobs->toArray());
    }

    /**
     * should create a new job
     *
     * @return 200 - job successfully created
     * @return 409 - job already exists
     */
    public function create(Request $request) {
        // todo validation
        // todo check if user is allowed to make this request // only admins or companyadmins
        $params = $request->all();
        $exist = Job::where('title', $params['title'])->get();

        // check if there are title duplicates in title
        if (count($exist) != 0) {

            return response()->json([
                'message' => 'Jobname already exist in job',
                'job' => $exist
            ], 409); 

        }

        $job = Job::create($params);

        return response()->json([
                'message' => 'Job successfully created',
                'job_id' => $job->id
            ], 201);
    }

    /**
     * updates a specific job by id
     *
     * @return 200 - successfully updated
     * @return 404 - job does not exist
    */
    public function update(Request $request, $id) {
        // todo validation
        // todo check if user is allowed to make this request // only admins
        $params = $request->all();
        $exist = Job::where('title', $params['title'])
            ->where('id','!=', $id)
            ->get();
        $job = Job::find($id);

        if (empty($job)) {
            return response()->json([
                'message' => 'Job does not exist',
            ], 404);
        }

        // check if there are title duplicates in title
        if (count($exist) != 0) {

            return response()->json([
                'message' => 'Jobname already exist in the listed job',
                'job' => $exist
            ], 409); 

        }

        $job = $job->update($params);

        return response()->json([
                'message' => 'Job successfully updated'
            ], 200);
    }

    /**
     * deletes a specific job by id
     *
     * @return 200 - successfully deleted
     * @return 404 - job does not exist 
     */
    public function delete($id) {
        // todo check if there is an already
        // used user with this as foreign key
        // todo check if user is allowed to see this request // only superadmins
        $job = Job::find($id);

        if ($job == NULL) {
            return response()->json([
                'message' => 'Job does not exist',
            ], 404);
        }

        $job->delete();

        return response()->json([
                'message' => 'Job successfully deleted',
            ], 200);
    }
}
