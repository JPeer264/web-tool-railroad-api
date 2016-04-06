<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;

class UserController extends Controller
{
    public function index() {

    }

    // todo get user (one or all -> login)
      public function getUser($id)
       {
         $user  = User::findOrFail($id);

         return response()->json($user);
       }

     public function getAllUsers()
      {
          $user  = User::all()->value('id', 'name', 'job_id', 'company_id', 'picture_alt', 'picture_location');
          return response()->json($user);
      }

      public function getUsersJob($id)
       {
           $user  = User::where('company_id', $id)->value('id', 'name', 'job_id', 'company_id', 'picture_alt', 'picture_location');
           return response()->json($user);
       }

       public function getUsersCompany($id)
        {
            $user  = User::where('job_id', $id)->value('id', 'name', 'job_id', 'company_id', 'picture_alt', 'picture_location');
            return response()->json($user);
        }


    // todo update user (just one)
    public function updateUsers(Request $request, $id)
     {
         $user  = User::find($id);

         $user->company_id = $request->input ('company_id');
         $user->role_id = $request->input ('role_id');
         $user->job_id = $request->input ('job_id');
         $user->firstname = $request->input ('firstname');
         $user->lastname = $request->input ('lastname');
         $user->password = $request->input ('password');
         $user->gender = $request->input ('gender');
         $user->picture_alt = $request->input ('picture_alt');
         $user->picture_location = $request->input ('picture_location');
         $user->email = $request->input ('email');
         $user->country = $request->input ('country');
         $user->city = $request->input ('city');
         $user->address = $request->input ('address');
         $user->birthday = $request->input ('birthday');
         $user->Twitter = $request->input ('twitter');
         $user->Facebook = $request->input ('facebook');
         $user->LinkedIn = $request->input ('linkedin');
         $user->Xing = $request->input ('xing');

         $user->save();
         return response()->json($user);
     }

    // todo delete user (just one)
    public function deleteUser($id)
    {
        $user  = User::find($id);
        $user->delete();

        return response()->json('deleted user');
    }
    // todo refresh token (returns a new one
    // todo create user (one)
    public function updateUsers(Request $request)
     {
       $user = new User;

       $user->company_id = $request->input ('company_id');
       $user->role_id = $request->input ('role_id');
       $user->job_id = $request->input ('job_id');
       $user->firstname = $request->input ('firstname');
       $user->lastname = $request->input ('lastname');
       $user->password = $request->input ('password');
       $user->gender = $request->input ('gender');
       $user->email = $request->input ('email');
       $user->country = $request->input ('country');
       $user->city = $request->input ('city');
       $user->signup_comment = $request->input ('signup_comment');

       $user->save();
       return response()->json($user);
     }
}
