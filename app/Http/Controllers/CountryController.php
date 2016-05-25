<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Country;

class CountryController extends Controller
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
     * should get one specific country by id
     *
     * @return 200 {Object} - a json with one country
     * @return 404 - company not found
     */
    public function get($id) {
        $country = Country::select('id', 'name', 'capital')
            ->find($id);

        if (empty($country)) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }

        return response()->json($country->toArray());
    }

    /**
     * should get every country
     *
     * @return 200 {Array} - within this array several single objects as country
     */
    public function getAll(Request $request) {

        $countries = Country::select('id', 'name', 'capital')->get();

        return response()->json($countries->toArray());
    }
}
