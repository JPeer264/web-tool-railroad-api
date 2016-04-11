<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Comment;

class CommentController extends Controller
{
    /**
     * should create a new comment
     *
     * @return 201 - comment successfully created
     */
    public function create(Request $request, $id) {
        // todo validation
        // todo update real user
        // todo check if user is allowed to make this request // allowed to see topic??
        $params = $request->all();
        $params['user_id'] = 1;
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