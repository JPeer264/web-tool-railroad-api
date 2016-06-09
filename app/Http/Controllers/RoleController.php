<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Role;

class RoleController extends Controller
{
    

    /**
     * should get every role
     *
     *
     * @return 200 {Array} - within this array several single objects as job
     * @return 404 - no jobs found
     */
    public function getAll(Request $request) {
        // todo check for company filter
        $roles = Role::get();

        return response()->json($roles->toArray());
    }


}
