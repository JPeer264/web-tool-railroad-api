<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index() {

    }

    // todo get user (one or all -> login)
      public function getUser($id)
       {
         $Person  = Person::findOrFail($id);

         return response()->json($Person);
       }

     public function getAllUsers()
      {
          $Person  = Person::all()->value('id', 'name', 'id_job', 'id_company', 'picture_alt', 'picture_location');
          return response()->json($Person);
      }

      public function getUsersJob($id)
       {
           $Person  = Person::where('id_company', $id)->value('id', 'name', 'id_job', 'id_company', 'picture_alt', 'picture_location');
           return response()->json($Person);
       }

       public function getUsersCompany($id)
        {
            $Person  = Person::where('id_job', $id)->value('id', 'name', 'id_job', 'id_company', 'picture_alt', 'picture_location');
            return response()->json($Person);
        }


    // todo update user (just one)
    public function updateUsers(Request $request, $id)
     {
         $Person  = Person::find($id);

         $Person->id_company = $request->input ('id_company');
         $Person->id_role = $request->input ('id_role');
         $Person->id_job = $request->input ('id_job');
         $Person->firstname = $request->input ('firstname');
         $Person->lastname = $request->input ('lastname');
         $Person->password = $request->input ('password');
         $Person->gender = $request->input ('gender');
         $Person->picture_alt = $request->input ('picture_alt');
         $Person->picture_location = $request->input ('picture_location');
         $Person->email = $request->input ('email');
         $Person->country = $request->input ('country');
         $Person->city = $request->input ('city');
         $Person->address = $request->input ('address');
         $Person->birthday = $request->input ('birthday');
         $Person->Twitter = $request->input ('twitter');
         $Person->Facebook = $request->input ('facebook');
         $Person->LinkedIn = $request->input ('linkedin');
         $Person->Xing = $request->input ('xing');

         $Person->save();
         return response()->json($Person);
     }

    // todo delete user (just one)
    public function deleteUser($id)
    {
        $Person  = Person::find($id);
        $Person->delete();

        return response()->json('deleted user');
    }
    // todo refresh token (returns a new one
    // todo create user (one)
    public function updateUsers(Request $request)
     {
       $Person = new Person;

       $Person->id_company = $request->input ('id_company');
       $Person->id_role = $request->input ('id_role');
       $Person->id_job = $request->input ('id_job');
       $Person->firstname = $request->input ('firstname');
       $Person->lastname = $request->input ('lastname');
       $Person->password = $request->input ('password');
       $Person->gender = $request->input ('gender');
       $Person->email = $request->input ('email');
       $Person->country = $request->input ('country');
       $Person->city = $request->input ('city');
       $Person->signup_comment = $request->input ('signup_comment');

       $Person->save();
       return response()->json($Person);
     }
}
