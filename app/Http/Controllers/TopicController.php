<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Topic;
use App\Category;
use Carbon\Carbon;
use App\Http\Controllers\Filter;

class TopicController extends Controller
{
    /**
     * should get one specific topic by id
     *
     * @return 200 {Object} - a json with one topic
     * @return 404 - topic not found
     */
    public function get(Request $request, $id) {
        // todo validation
        // todo check if user is allowed to see this request // is user in the right company or job?
        $topics = Topic::with('user', 'comment', 'job')->find($id);

        if (empty($topics)) {
            return response()->json([
                'message' => 'Topic not found',
            ], 404);          
        }

        return response()->json($topics->toArray());
    }

    /**
     * should get every topic
     *
     * @return 200 {Array} - within this array several single objects as topic
     * @return 404 - category not found
     */
    public function getAllByCategory(Request $request, $id) {
        // todo validation
        // todo check if user is allowed to see this request // is user in the right company or job?
        $topics = Topic::with('user')
            ->where('category_id', $id)
            ->get();
        $category = Category::find((int)$id);

        $filter = new Filter($topics, $request->all());

        $filtered = $filter
            ->byParameters('job')
            ->byParameters('company');

        if (empty($category)) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);          
        }

        return response()->json($filtered->getArray());
    }

    /**
     * same as getAllByCategory but with less information
     * used in CategoryController
     *
     * @return 200 {Array} - within this array several single objects as topic
     * @return 404 - category not found
     */
    public function getAllByCategoryLessInformation(Request $request, $id) {
        // todo validation
        // todo check if user is allowed to see this request // is user in the right company or job?
        $topics = Topic::where('category_id', $id)->get();

        $category = Category::find((int)$id);

        $filter = new Filter($topics, $request->all());

        $filtered = $filter
            ->byParameters('job')
            ->byParameters('company');

        if (empty($category)) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);          
        }

        $topics = $filtered->getArray();

        // delete added elquents and return filtered topics
        $count = 0;
        foreach ($topics as $topic) {
            unset($topic['job']);
            unset($topic['company']);

            $topics[$count] = $topic;

            $count++;
        }

        return response()->json($topics);
    }

    /**
     * should create a new topic
     *
     * @return 201 - topic successfully created
     * @return 409 - topic already exists
     */
    public function create(Request $request, $id) {
        // todo validation
        // todo update real user and type
        // todo check if user is allowed to make this request // admins for all companys and jobs - user just in their own
        $params = $request->all();
        $params['category_id'] = $id;
        $params['user_id'] = 1;
        $params['type_id'] = 1;

        $exist = Topic::with('job', 'company')
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
                'message' => 'Topicname already exist in the listed job or company',
                'existIn' => $existIn
            ], 409); 

        } else if (count($exist) != 0) {
            return response()->json([
                    'message' => 'Topicname already exist'
                ], 409); 
        }

        $topic = Topic::create($params);
        $topicfilter = new Filter($topic, $params);
        // save into necessary pivottables if no error
        $topicfilter
            ->saveToPivot('job')
            ->saveToPivot('company');

        return response()->json([
                'message' => 'Topic successfully created',
                'topic_id' => $topic->id
            ], 201);
    }

    /**
     * updates a specific topic by id
     *
     * @return 200 - successfully updated
     * @return 404 - topic does not exist
     * @return 405 - topic cannot be changed anymore
    */
    public function update(Request $request, $id) {
        // todo validation
        // todo check if user is allowed to make this request // only admins or users who created the specific topic
        $params = $request->all();
        $unchangeInMin = 10; // minutes

        // check if topic is changable 
        $date = Topic::find($id)->created_at;
        $now = Carbon::now();

        if ($now->diffInMinutes($date->addMinutes($unchangeInMin)) > 0) {
            return response()->json([
                'message' => 'Topic cannot be changed anymore',
            ], 405);
        }

        // filter parameters for update pivot
        $topicpivot = Topic::with('job', 'company')->where('id', $id)->get();
        $filterpivot = new Filter($topicpivot, $params);
        $pivotparams = $filterpivot
            ->prepareParameterForPivotUpdate('job')
            ->prepareParameterForPivotUpdate('company')
            ->globalParameters;

        // exist filter
        $exist = Topic::with('job', 'company')
            ->where('id','!=', $id)
            ->where('title', $params['title'])
            ->get();
        $existfilter = new Filter($exist, $params);    
        $existfilter
            ->byUsedPivots('company')
            ->byUsedPivots('job');

        // filter for updating
        $topic = Topic::find($id);
        $filter = new Filter($topic, $pivotparams);

        if ($topic == NULL) {
            return response()->json([
                'message' => 'Topic does not exist',
            ], 404);
        }

        if ($existfilter->isUsedByPivots()) {
            // if there are already used filters in pivots
            $existIn = $existfilter
                ->getUsedPivots('company')
                ->getUsedPivots('job')
                ->usedPivots;

            return response()->json([
                'message' => 'Topicname already exist in the listed job or company',
                'existIn' => $existIn
            ], 409); 

        } else if (count($exist) != 0) {
            return response()->json([
                    'message' => 'Topicname already exist'
                ], 409); 
        }

        $filter
            ->updatePivot('job')
            ->updatePivot('company');

        $update = $topic->update($params);

        return response()->json([
                'message' => 'Topic successfully updated',
            ], 200);
    }

    /**
     * deletes a specific topic by id
     *
     * @return 200 - successfully deleted
     * @return 404 - topic does not exist 
     */
    public function delete($id) {
        // todo check if user is allowed to make this request // only superadmins
        $topic = Topic::find($id);

        if ($topic == NULL) {
            return response()->json([
                'message' => 'Topic does not exist',
            ], 404);
        }

        $topic->delete();

        return response()->json([
                'message' => 'Topic successfully deleted',
            ], 200);
    }
}
