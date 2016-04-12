<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Job;
use App\Company;
use App\Http\Controllers\Filter;

class UserController extends Controller
{

    /**
     * should get one specific user by id
     *
     * @return 200 {Object} - a json with one user
     * @return 404 - user not found
     */
      public function get(Request $request, $id)
       {
         $user  = User::find($id);

         if (empty($user)) {
             return response()->json([
                 'message' => 'User not found',
             ], 404);
         }

         return response()->json($user->toArray());
       }

       /**
        * should get every user
        *
        * can be filtered by one or more companies, job
        *
        * @return 200 {Array} - within this array several single objects as user
        * @return 404 - no users found
        */
     public function getAll(Request $request)
      {
          $user = User::with('role', 'job', 'company')->get();
          $filter = new Filter($user, $request->all());

          // filter by given parameters
          $filtered  = $filter
              ->byParams('company')
              ->byParams('job');

          return response()->json($user->toArray());
      }

      /**
       * should create a new category, but fails if a name is duplicated
       *
       * @return 201 - category successfully created
       * @return 409 - category already exists
       */
      public function register(Request $request)
      {
          $params = $request->all();
          var_dump($params);
          $exist = User::where('email', $params['email'])->get();
          if(count($exist)!=0){
              return response()->json([
                  'message' => 'Email already exist in database',
                  'existIn' => $existIn
              ], 409);
          }
          /* if(ranking= admin)
          {
          less stuff required with validate and accepted to true
        }*/

          if(isset($params['accepted'])
          {
              $params['accepted']=0;
          }

          $user = User::create($params);


          return response()->json([
                  'message' => 'User successfully created',
                  'user_id' => $user->id
              ], 201);
      }

    // todo update user (just one)
    public function update(Request $request, $id)
     {
         $user = User::find($id);
         if ($user == NULL) {
             return response()->json([
                 'message' => 'User does not exist',
             ], 404);
         }
         $params = $request->all();

         $user->update($params);

         return response()->json([
                 'message' => 'User successfully updated',
             ], 200);
     }

     /**
      * deletes a specific user by id
      *
      * @return 200 - successfully deleted
      * @return 404 - user does not exist
      */    public function delete($id)
    {
        $user  = User::find($id);

        if ($user == NULL) {
            return response()->json([
                'message' => 'User does not exist',
            ], 404);
        }

        $user->delete();

        return response()->json([
                'message' => 'User successfully deleted',
            ], 200);

    }

}
