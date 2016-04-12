<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Comment;

class CommentController extends Controller
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
     * should create a new comment
     *
     * @return 201 - comment successfully created
     */
    public function create(Request $request, $id) {

        $this->validate($request, [
           'user_id' => 'required|integer',
           'topic_id' => 'required|integer',
           'content'=>'required|string',
        ]);

         // todo check if user is allowed to make this request // allowed to see topic?
        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        $params['user_id'] = $user->id;
        $params['topic_id'] = $id;

        $comment = Comment::create($params);

        return response()->json([
                'message' => 'Comment successfully created',
                'comment_id' => $comment->id
            ], 201);
    }

    // (todo change comment)
    // (todo delete comment)

}
