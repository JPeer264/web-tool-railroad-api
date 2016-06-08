<?php

namespace App\Http\Controllers;

use Tymon\JWTAuth\JWTAuth;
use Illuminate\Http\Request;
use App\Http\Controllers\UserlogController;
use App\Userlog;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

/**
 * Class AuthController
 * @package App\Http\Controllers
 */
class AuthenticationController extends Controller
{
    /**
     * @var JWTAuth
     */
    private $auth;

    /**
     * @param JWTAuth $auth
     */
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function authenticate(Request $request)
    {
        // grab credentials from the request
        $credentials = $request->only('email', 'password');
        $params = $request->all();

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

        //check if user is accepted
        if ($user->accepted != 2) {
            return response()->json([
                'error' => 'User is not accepted',
            ], 403);
        }

        // update last login
        // and return the old value
        // $last_login = $user->last_login;
        // $user->last_login = Carbon::now()->format('Y-m-d H:i:s');
        // $user->login_count += 1;
        // $user->save();
        // $user->last_login = $last_login;

        $login = Userlog::create([ 'user_id' => $user->id]);

        // all good so return the token
        return response()->json([
            'token' => $token,
            'user' => $user
        ]);
    }
}
