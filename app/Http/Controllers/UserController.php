<?php

/*
FishController :D
       o                 o
                  o
         o   ______      o
           _/  (   \_
 _       _/  (       \_  O
| \_   _/  (   (    0  \
|== \_/  (   (          |
|=== _ (   (   (        |
|==_/ \_ (   (          |
|_/     \_ (   (    \__/
          \_ (      _/
            |  |___/
           /__/
*/

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Job;
use App\Company;
use App\Http\Controllers\Filter;
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
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
    * should get one specific user by id
    *
    * @return 200 {Object} - a json with one user
    * @return 404 - user not found
    */
    public function get(Request $request, $id) {

        // todo check if user is allowed to make this request // accessible for everybody? - at least same company
        $user  = User::with('country', 'job')->find($id);

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
        $this->validate($request, [
            'company' => 'array|integer',
            'job' => 'array|integer',
        ]);

        $user = User::get();
        $filter = new Filter($user, $request->all());

        // filter by given parameters
        $filtered = $filter
            ->byParameters('company')
            ->byParameters('job');

        return response()->json($filtered->getArray());
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
        $exist = User::where('email', $params['email'])->get();

        if (count($exist)!=0){
            return response()->json([
                    'message' => 'Email already exist in database',
                    //'existIn' => $existIn
                ], 409);
        }

        $user = $this->auth->parseToken()->authenticate();

        if($user->role_id == 1) {
            //ranking= admin
            //less stuff required with validate and accepted to true
            $this->validate($request, [
                'email' => 'required|email',
                'company_id'=>'required|integer'
            ]);

            $params['accepted']=1;
            $password=str_random(6);
            $params['password']= Hash::make($password);
    
            $invite_expire=Crypt::encrypt(Carbon::now()->addDay(5));

            $data = [
               'password' => $password,
               'invite_expire' => $invite_expire
            ];
            Mail::send('emails.invite', $data, function ($message) {
                //$message->to($params['email']);
            });

        } else {
            if(isset($params['accepted'])) {
                $params['accepted']=0;
            }


            $this->validate($request, [
                'email' => 'required|email|unique:user',
                'password' => 'required',
                'firstname'=> 'required|string',
                'lastname'=>'required|string',
                'gender'=>'required|string',
                'birthday'=>'required|integer',
                'country_id'=>'required|integer',
                'signup_comment'=>'required|string|max:1000',
                'company_id'=>'required|integer',
                'job_id'=>'required|integer',
                'role_id'=>'integer',
                'city'=>'string',
                'address'=>'string',
                'Twitter'=>'string',
                'Facebook'=>'string',
                'LinkedIn'=>'string',
                'Xing'=>'string',
            ]);

            $params['password']= Hash::make($params['password']);

        }
        var_dump($params);
        $user = User::create($params);

        return response()->json([
                'message' => 'User successfully created',
                'user_id' => $user->id
            ], 201);
    }

    // todo update user (just one)
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'firstname'=> 'required|string',
            'lastname'=>'required|string',
            'gender'=>'required|string',
            'birthday'=>'required|integer',
            'country_id'=>'required|integer',
            'signup_comment'=>'required|string|max:1000',
            'company_id'=>'required|integer',
            'job_id'=>'required|integer',
            'city'=>'string',
            'address'=>'string',
            'Twitter'=>'string',
            'Facebook'=>'string',
            'LinkedIn'=>'string',
            'Xing'=>'string',
            'picture_alt'=>'string',
        ]);

        $params['password']= Hash::make($params['password']);

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
    */
    public function delete($id)
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
