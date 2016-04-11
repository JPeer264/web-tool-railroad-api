<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Type;
use App\Http\Controllers\Filter;

class TypeController extends Controller
{
    /**
     * should get one specific type by id
     *
     * @return 200 {Object} - a json with one type
     * @return 404 - type not found
     */
    public function get(Request $request, $id) {
        // todo validation
        $type = Type::find($id);

        if (empty($type)) {
            return response()->json([
                'message' => 'Type not found',
            ], 404);          
        }

        return response()->json($type);
    }

    /**
     * should create a new type
     *
     * @return 201 - type successfully created
     */
    public function create(Request $request) {
        // todo validation
        // todo check if user is allowed to make this request // only admins
        $params = $request->all();

        $type = Type::create($params);

        return response()->json([
                'message' => 'Type successfully created',
                'type_id' => $type->id
            ], 201);
    }

    /**
     * deletes a specific type by id
     *
     * @return 200 - successfully deleted
     * @return 404 - type does not exist 
     */
    public function delete($id) {
        // todo check if there is an already
        // used topic with this as foreign key
        // todo check if user is allowed to make this request // only admins
        $type = Type::find($id);

        if ($type == NULL) {
            return response()->json([
                'message' => 'Type does not exist',
            ], 404);
        }

        $type->delete();

        return response()->json([
                'message' => 'Type successfully deleted',
            ], 200);
    }

    // (todo change type)
}
