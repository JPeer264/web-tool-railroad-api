<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Comment;
use App\File;

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
           'content'=>'required|string',
        ]);

         // todo check if user is allowed to make this request // allowed to see topic?
        $params = $request->all();
        $files = $request->files->all();
        $user = $this->auth->parseToken()->authenticate();

        $params['user_id'] = $user->id;
        $params['topic_id'] = $id;

        $comment = Comment::create($params);
         var_dump($files);

        $file = new FileController($request);
        $params['comment_id'] =  $comment->id;
        foreach ($files as $key => $value) {
            $fileMeta = $file->saveFile($params, $value);
            if($fileMeta){
                $jsonres = $fileMeta->getData();

                if( $jsonres->message == 'filename already exist in this topic'){
                    return response()->json([
                            'message' => 'filename already exist in this topic'
                        ], 409);
                }
            }
        }


        return response()->json([
                'message' => 'Comment successfully created',
                'comment_id' => $comment->id
            ], 201);
    }

    // (todo change comment)
    // (todo delete comment)

}
