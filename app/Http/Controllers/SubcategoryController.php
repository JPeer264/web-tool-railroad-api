<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\TopicController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Subcategory;

class SubcategoryController extends Controller
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
     * should get one specific subcategory by id
     *
     * @return 200 {Object} - a json with one subcategory
     * @return 404 - subcategory not found
     */
    public function get(Request $request, $id) {

        // get topics with their comment and user
        // comments are sorted by created_at desc
        $subcategory = Subcategory::with('category')
            ->with(['topic' => function ($q) {
                $q->select('id', 'title', 'subcategory_id', 'user_id', 'type_id', 'created_at')
                    ->with(['comment' => function ($q) {
                        $q->select('id', 'user_id', 'topic_id')
                            ->orderBy('created_at', 'desc')
                            ->with(['user' => function ($q) {
                                $q->select('id', 'firstname', 'lastname', 'picture_location');
                            }]);
                    }])
                    ->with(['user' => function ($q) {
                        $q->select('id', 'firstname', 'lastname');
                    }]);
            }])
            ->find($id);

        // filter the latest comment per topic
        foreach ($subcategory['topic'] as $topics) {
            if (isset($topics['comment'][0])) {
                $comment = $topics['comment'][0];

                // clear object
                unset($topics['comment']);

                // regenerate object
                $topics['latest_comment'] = $comment;
            } else {
                unset($topics['comment']);
            }
        }

        unset($subcategory->deleted_at);    

        if (empty($subcategory)) {
            return response()->json([
                'message' => 'Subcategory not found',
            ], 404);
        }

        return response()->json($subcategory);
    }

    /**
     * should get every subcategory with subsubcategories
     *
     * @return 200 {Array} - within this array several single objects as subcategory
     */
    public function getAll(Request $request) {

        $subcategories = Subcategory::with('category')->get();

        return response()->json($subcategories->toArray());
    }

    /**
     * should create a new subcategory, but fails if a name is duplicated
     *
     * @return 201 - subcategory successfully created
     * @return 409 - subcategory already exists
     */
    public function create(Request $request, $category_id) {

        // todo check if it is a superadmin (1)
        $this->validate($request, [
           'title' => 'required|string|unique:type',
        ]);

        $params = $request->all();
        $params['category_id'] = $category_id;
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to update subcategories.'
                ], 401);
        }

        $exist = Subcategory::where('title', $params['title'])->get();

        if (!count($exist->toArray()) == 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409);
        }

        $subcategories = Subcategory::create($params);

        return response()->json([
                'message' => 'Subcategory successfully created',
                'category_id' => $subcategories->id
            ], 201);
    }

    /**
     * updates a specific subcategory by id
     *
     * @return 200 - successfully updated
     * @return 404 - subcategory does not exist
     * @return 409 - subcategory already exist
    */
    public function update(Request $request, $id) {

        // todo check if it is a superadmin (1)
        $this->validate($request, [
           'title' => 'required|string|unique:type',
        ]);

        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to update subcategories.'
                ], 401);
        }

        $subcategory = Subcategory::find($id);
        $exist = Subcategory::
            where('title', $params['title'])
            ->where('id', '!=', $id)
            ->get();

        if ($subcategory == NULL) {
            return response()->json([
                'message' => 'Subcategory does not exist',
            ], 404);
        }

        if (!count($exist->toArray()) == 0) {
            return response()->json([
                    'message' => 'Categoryname already exist'
                ], 409);
        }

        $update = $subcategory->update($params);

        return response()->json([
                'message' => 'Subcategory successfully updated',
            ], 200);
    }

    /**
     * deletes a specific subcategory by id
     *
     * @return 200 - successfully deleted
     * @return 404 - subcategory does not exist
     */
    public function delete($id) {
        $user = $this->auth->parseToken()->authenticate();

        // check for right permission
        if ($user->role_id == 1) {
            // superadmins only
            return response()->json([
                    'message' => 'Just admins are allowed to delete subcategories.'
                ], 401);
        }

        $subcategory = Subcategory::find($id);

        if ($subcategory == NULL) {
            return response()->json([
                'message' => 'Subcategory does not exist',
            ], 404);
        }

        $subcategory->delete();

        return response()->json([
                'message' => 'Subcategory successfully deleted',
            ], 200);
    }
}
