<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\User;
use App\Company;
use App\Comment;
use Carbon\Carbon;

class MissedActivityController extends Controller
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
     * should get latest activity - with latest_topic, latestComments, latest_user
     * if it is an admin - latest_user_requests
     *
     * @return 200 {Object} - a json with latest activity
     */
    public function getLatest(Request $request, TopicController $topicCtrl) {

        $userlogs = $this->auth->user()->userlog()->get();

        $cachedUserlog = null;
        $comments = array();
        $commentsCreatedAt = array();
        $latestComments = array();
        $latestTopics = array();
        $latestUserRequests = array();
        $topics = $topicCtrl->getAll($request);

        // check when the user last logged in before "today"
        // if he will login more often it will not overwrite form the previous logged in
        foreach ($userlogs as $userlogKey => $userlog) {
            if (!isset($cachedUserlog)) {
                $cachedUserlog = $userlog;
            }

            if (!$cachedUserlog['created_at']->isToday()) {
                $cachedUserlog = $userlog;
                break;
            }

            $cachedUserlog = $userlog;
        }

        // push all comments to the comment array
        foreach ($topics as $topicKey => $topic) {
            if (isset($topic['comment'])) {
                foreach ($topic['comment'] as $comment) {
                    array_push($comments, $comment);
                }
            }
        }

        // prepare for filtering the $comments
        foreach ($comments as $commentKey => $comment) {
            $commentsCreatedAt[$commentKey] = $comment['created_at'];
        }

        // sort by created DESC
        array_multisort($commentsCreatedAt, SORT_DESC, $comments);

        /*************************
         **** LATEST COMMENTS ****
         *************************/

        foreach ($comments as $commentKey => $comment) {
            $createdComment = Carbon::parse($comment['created_at']);

            if ($createdComment->lt($cachedUserlog->created_at)) {
                break;
            }

            array_push($latestComments, $comment);
        }

        /***********************
         **** LATEST TOPICS ****
         ***********************/

        foreach ($topics as $topicKey => $topic) {
            $createdTopic = Carbon::parse($topic['created_at']);

            if ($createdTopic->lt($cachedUserlog->created_at)) {
                break;
            }

            unset($topic['comment']);
            unset($topic['job']);
            unset($topic['company']);
            array_push($latestTopics, $topic);
        }

        /*************************
         **** LATEST ACTIVITY ****
         *************************/
        $latest_activity = [
            'latest_comments' => $latestComments,
            'latest_topics' => $latestTopics
        ];

        return response()->json($latest_activity);
    }
}
