<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TopicController extends Controller
{
    /**
     * should get one specific topic by id
     *
     * @return 200 {Object} - a json with one topic
     * @return 404 - topic not found
     */
    public function get(Request $request, $id) {
        // todo janpeer check if filter isset and apply
        // todo janpeer get information from DB 

        $err = false;

        if($err) {
            abort(404, 'topic not found');
        }

        $return = ['id' => '1', 'name' => 'testtopic'];

        return response()->json($return);
    }

    /**
     * should get every topic
     *
     * @return 200 {Array} - within this array several single objects as topic
     */
    public function getAllByCategory(Request $request, $id) {
        // todo janpeer check if filter isset and apply
        // todo janpeer check for error 409

        $return = (object)['id' => $id, 'name' => 'categoryname', 'topics' => [(object)['id' => '1', 'name' => 'testtopic'], (object)['id' => '2', 'name' => 'testtopic']]];

        return response()->json($return);
    }

    /**
     * should create a new topic
     *
     * @return 200 - topic successfully created
     * @return 409 - topic already exists
     */
    public function create(Request $request) {
        // todo janpeer create a topic with given information using $response()->all();

        $err = false;

        if($err) {
            abort(409, 'topic already exists');
        }

        return; // returns 200
    }

    /**
     * updates a specific topic by id
     *
     * @return 200 - successfully updated
     * @return 404 - topic does not exist
     * @return 405 - topic cannot be changed anymore
    */
    public function update(Request $request, $id) {
        // todo janpeer update the topic information using $response()->all();
        // todo janpeer check for error 404

        $err = false;
        $toolate = false;

        if($err) {
            abort(404, 'topic does not exists');
        } else if ($toolate) {
            abort(405, 'topic cannot be changed anymore');
        }

        return; // returns 200
    }

    /**
     * deletes a specific topic by id
     *
     * @return 200 - successfully deleted
     * @return 404 - topic does not exist 
     */
    public function delete(Request $request, $id) {
        // todo janpeer delete the topic
        // todo janpeer check for error 404

        $err = false;

        if($err) {
            abort(404, 'topic does not exists');
        }

        return; // returns 200
    }
}
