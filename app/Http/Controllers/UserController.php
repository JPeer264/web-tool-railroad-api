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
use Tymon\JWTAuth\Exceptions\JWTException;
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
        $this->mail_subject_invite = env('MAIL_SUBJECT_INVITE');
        $this->mail_subject_forgot = env('MAIL_SUBJECT_FORGOT');
    }


    /**
    * should get one specific user by id
    *
    * @return 200 {Object} - a json with one user
    * @return 404 - user not found
    */
    public function get(Request $request, $id) {

        // todo check if user is allowed to make this request // accessible for everybody? - at least same company
        $user = User::with('country', 'job')
                ->with(['company' =>function ($q) {
                    $q->with(['country' => function($q){
                        $q->select('id', 'name');

                    }]);
                    $q->with(['user' => function ($q) {
                            $q->select('id', 'firstname', 'lastname','job_id','company_id', 'picture_location', 'picture_alt')
                                ->with(['job' => function ($q) {
                                    $q->select('id', 'title');
                                }]);
                        }]);
                }])
                ->with(['topic' =>function($q){
                    $q->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();
                }])
                ->with(['comment' =>function($q){
                    $q->orderBy('created_at', 'desc')
                        ->take(3)
                        ->get();
                }])
                ->with('userlog')
                ->find($id);



        if (empty($user)) {
            return response()->json([
                    'error' => 'User not found',
                ], 404);
        }

        $user = $user->toArray();
        $user['login_count'] = count($user['userlog']);
        $user['last_login'] = $user['userlog'][1]['created_at'];
        unset($user['userlog']);

        return response()->json($user);
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
            'company' => 'array',
            'job' => 'array',
        ]);

        $user = User::with(['company' => function ($q) {
                $q->select('id', 'name');
            }])
            ->with(['job' => function ($q) {
                $q->select('id', 'title');
            }]);

        $filter = new Filter($user->get(), $request->all());

        // filter by given parameters
        $filtered = $filter
            ->byParameters('company')
            ->byParameters('job');

        return response()->json($filtered->getArray());
    }

    /**
    * should get limited info for every user
    *
    *
    * @return 200 {Array} - within this array several single objects as user
    * @return 404 - no users found
    */
    public function getAllLimited(Request $request)
    {

        $users = User::select('id', 'firstname', 'lastname')->get();

        return response()->json($users->toArray());
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

        if($this->auth->user()){
            $exist = User::where('email', $params['email'])->get();

            if (count($exist)!=0){
                return response()->json([
                        'error' => 'Email already exist in database',
                        //'existIn' => $existIn
                    ], 409);
            }

            $user = $this->auth->parseToken()->authenticate();

            if($user->role_id == 1 || $user->role_id == 2 || $user->role_id == 3) {
                //ranking= admin
                //less stuff required with validate and accepted to true
                $this->validate($request, [
                    'email' => 'required|email',
                ]);

                if($user->role_id == 3){
                    $params['company_id']=$user->company_id;
                }else{
                    $params['company_id']=1;
                }

            }else if ($user->role_id == 3){
                $this->validate($request, [
                    'email' => 'required|email',
                ]);
                $params['company_id']=$user->company_id;
            }

            $params['accepted']=1;
            $password=str_random(6);
            $params['password']= Hash::make($password);
            $params['role_id']=4;
            $params['job_id']=4;

            $invite_expire=Crypt::encrypt(Carbon::now()->addDay(5));

            $data = [
               'password' => $password,
               'invite_expire' => $invite_expire
            ];

            Mail::send('emails.invite', $data, function ($message) use($params){
                $message->to($params['email'])->subject($this->mail_subject_invite);
            });

        }else {
            $this->validate($request, [
                'email' => 'required|email|unique:user',
                'password' => 'required',
                'firstname'=> 'required|string',
                'lastname'=>'required|string',
                'gender'=>'required|string',
                'birthday'=>'required|date',
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
            ]);

                $exist = User::where('email', $params['email'])->get();

                if (count($exist)!=0){
                    return response()->json([
                            'error' => 'Email already exist in database',
                            //'existIn' => $existIn
                        ], 409);
                }

                $params['password']= Hash::make($params['password']);

                if(isset($params['accepted'])) {
                    $params['accepted']=0;
                }
                $params["role_id"]=4;
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
        $this->validate($request, [
            'email' => 'email',
            'password' => 'string',
            'firstname'=> 'string',
            'lastname'=>'string',
            'gender'=>'string',
            'birthday'=>'date',
            'country_id'=>'integer',
            'signup_comment'=>'string|max:1000',
            'company_id'=>'integer',
            'job_id'=>'integer',
            'city'=>'string',
            'address'=>'string',
            'Twitter'=>'string',
            'Facebook'=>'string',
            'LinkedIn'=>'string',
            'Xing'=>'string',
            'picture_alt'=>'string',
        ]);

        $params = $request->all();

        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        $user = User::find($id);

        if ($user == NULL) {
            return response()->json([
                    'error' => 'User does not exist',
                ], 404);
        }

        // fileupload
        $file = new FileController($request);
        $fileMeta = $file->save('user', 'picture_alt', 1);

        // check, if not it will overwrite the database
        if ($fileMeta) {
            $params['picture_location'] = $fileMeta['filepath'];
        }

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
                    'error' => 'User does not exist',
                ], 404);
        }

        $user->delete();

        return response()->json([
                'message' => 'User successfully deleted',
            ], 200);
    }

    /**
    * updates/activates an invited user
    *
    * @return 200 - successfully activated/updates
    * @return 404 - user does not exist
    * @return 404 - token does not exist
    * @return 403 - user is not allowed to make this request
    * @return 403 - token has expired
    */
    public function registerInvite(Request $request){

        $this->validate($request, [
            'email' => 'email',
            'password' => 'string',
            'firstname'=> 'string',
            'lastname'=>'string',
            'gender'=>'string',
            'birthday'=>'date',
            'country_id'=>'integer',
            'city'=>'string',
            'address'=>'string',
            'Twitter'=>'string',
            'Facebook'=>'string',
            'LinkedIn'=>'string',
            'Xing'=>'string',
            'invite_token'=>'string',
        ]);

        $params = $request->all();
        $credentials = $request->only('email', 'password');


        if($params['invite_token']!=null) {
            $invite_expireDate=Crypt::decrypt($params['invite_token']);
            if(Carbon::now()->diffInDays($invite_expireDate, false)>=0){

                try {
                    // attempt to verify the credentials and create a token for the user
                    $token = $this->auth->attempt($credentials);

                    if (!$token) {
                        return response()->json(['error' => 'invalid_credentials'], 401);
                    }
                } catch (JWTException $e) {
                    // something went wrong whilst attempting to encode the token
                    return response()->json(['error' => 'could_not_create_token'], 500);
                }

                $user = $this->auth->user();

                if($user->accepted!=1){
                    return response()->json([
                        'error' => 'User not allowed to do make this request',
                    ], 403);
                }
                $params['role_id']=$user->role_id;
                $params['job_id']=$user->job_id;
                $params['company_id']=$user->company_id;
                $params['accepted']=2;
                $params['password'] = Hash::make($params['password']);

            }else{
                return response()->json([
                        'error' => 'The token has expired',
                    ], 403);
            }
        }else{
            return response()->json([
                    'error' => 'There is no token.',
                ], 404);
        }

        $user->update($params);

        return response()->json([
                'message' => 'User successfully updated',
            ], 200);
    }


     /**
    * send email with new password
    *
    * @return 200 - successfully changed password
    * @return 404 - user does not exist
    * @return 403 - user is not allowed to make this request
    */
    public function forgotPassword(Request $request){

        $params = $request->all();

        $this->validate($request, [
            'email' => 'email',
        ]);

        $user=User::where('email', $params['email'])->first();

        if ($user == NULL) {
            return response()->json([
                'error' => 'User does not exist',
            ], 404);
        }

        if($user->accepted!=2){
            return response()->json([
                'error' => 'User not allowed to do make this request',
                ], 403);
        }

        $password=str_random(6);
        $params['password']= Hash::make($password);

        $data = [
            'password' => $password,
        ];

        Mail::send('emails.forgot', $data, function ($message) use($params){
            $message->to($params['email'])->subject($this->mail_subject_forgot);
        });

        $user->update($params);

        return response()->json([
                'message' => 'User successfully updated',
        ], 200);
    }

}
