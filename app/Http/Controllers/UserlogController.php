<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Userlog;

class JobController extends Controller
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
     * should log an user
     *
     * @return 200 - new log successfully created
     */
    public function create(Request $request) {

        $user = $this->auth->user();

        $params = '';

        $login = Userlog::create($params);

        return true;
    }
}
