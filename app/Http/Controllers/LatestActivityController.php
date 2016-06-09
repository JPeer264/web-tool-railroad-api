<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\FilterHelper;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\User;
use App\Company;
use App\Topic;
use App\Comment;
use Carbon\Carbon;

class LatestActivityController extends Controller
{
    /**
     * @var JWTAuth
     */
    private $auth;

    /**
     * @param JWTAuth $auth
     */
    public function __construct(JWTAuth $auth, FilterHelper $filter) {
        $this->auth = $auth;
        $this->filter = $filter;
    }

    /**
     * should get latest activity - with latest_topic, latestComments, latest_user
     * if it is an admin - latest_user_requests
     *
     * @return 200 {Object} - a json with latest activity
     */
    public function getLatestMissed(Request $request, TopicController $topicCtrl) {

        $userlogs = $this->auth->user()->userlog()->get();

        $cachedUserlog = null;
        $comments = array();
        $commentsCreatedAt = array();
        $latestMissedComments = array();
        $latestComments = array();
        $latestTopics = array();
        $latestMissedTopics = array();
        $latestUserRequests = array();
        $topics = $topicCtrl->getAll($request);

        return $topics;

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

        /********************************
         **** LATEST MISSED COMMENTS ****
         ********************************/

        foreach ($comments as $commentKey => $comment) {
            $createdComment = Carbon::parse($comment['created_at']);

            if ($createdComment->lt($cachedUserlog->created_at)) {
                break;
            }

            array_push($latestMissedComments, $comment);
        }

        /***********************
         **** LATEST TOPICS ****
         ***********************/

        // if their are no latestMissedComments show the latest 3 comments
        if (count($latestMissedComments) == 0) {
            foreach ($comments as $commentKey => $comment) {

                if ($commentKey == 3) {
                    break;
                }

                array_push($latestComments, $comment);
            }
        } else {
            $latestComments = $latestMissedComments;
        }

        /******************************
         **** LATEST MISSED TOPICS ****
         ******************************/

        foreach ($topics as $topicKey => $topic) {
            $createdTopic = Carbon::parse($topic['created_at']);

            if ($createdTopic->lt($cachedUserlog->created_at)) {
                break;
            }

            unset($topic['comment']);
            unset($topic['job']);
            unset($topic['company']);
            array_push($latestMissedTopics, $topic);
        }

        /***********************
         **** LATEST TOPICS ****
         ***********************/

        // if their are no latestMissedTopics show the latest 3 topics
        if (count($latestMissedTopics) == 0) {
            foreach ($topics as $topicKey => $topic) {

                if ($topicKey == 3) {
                    break;
                }

                array_push($latestTopics, $topic);
            }
        } else {
            $latestTopics = $latestMissedTopics;
        }


        /*************************
         **** LATEST ACTIVITY ****
         *************************/
        $latest_activity = [
            'latest_comments' => $latestComments,
            'latest_topics' => $latestTopics,
        ];

        return response()->json($latest_activity);
    }

    /**
     * should get latest activity - with latest_topic, latestComments, latest_user
     * if it is an admin - latest_user_requests
     *
     * @return 200 {Object} - a json with latest activity
     */
    public function getLatestByUser(Request $request, $id) {
        $user = $this->auth->user();
        // topics from the requested person
        $topics = Topic::with('company', 'job')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $topicsAllowedToSee = Topic::with('company', 'job')
            ->select('id')
            ->orderBy('created_at', 'desc')
            ->get();

        // comments from the requested person
        $comments = Comment::where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        $this->filter->filterTopics($topics, 4);
        $this->filter->filterTopics($topicsAllowedToSee, 4);
        $latestComments = array();
        $latestTopics = array();
        $limit = 3;

        /********************++***
         **** LATEST COMMENTS ****
         **********************++*/

        if ($user->id >= 4) {
            foreach ($comments as $commentKey => $comment) {
                foreach ($topicsAllowedToSee as $topicKey => $topic) {
                    // break if $latest comments is more than 3
                    if (count($latestComments) == $limit) {
                        break;
                    }
                    // check if the comment can be seen
                    if ($topic['id'] == $comment['topic_id']) {
                        array_push($latestComments, $comment);
                    }
                }

                // break if $latest comments is more than 3
                if (count($latestComments) == $limit) {
                    break;
                }
            }
        } else {
            foreach ($comments as $commentKey => $comment) {
                // break if $latest comments is more than 3
                if (count($latestComments) == $limit) {
                    break;
                }

                array_push($latestComments, $comment);
            }
        }

        foreach ($topics as $topicKey => $topic) {
            // break if $latest comments is more than 3
            if (count($latestTopics) == $limit) {
                break;
            }

            unset($topic['job']);
            unset($topic['company']);
            array_push($latestTopics, $topic);
        }

        /*************************
         **** LATEST ACTIVITY ****
         *************************/
        $latest_activity = [
            'latest_comments' => $latestComments,
            'latest_topics' => $latestTopics,
        ];

        return response()->json($latest_activity);
    }
}
