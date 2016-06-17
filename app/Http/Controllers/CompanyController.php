<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tymon\JWTAuth\JWTAuth;
use App\Company;
use App\Job;
use App\User;
use App\Http\Controllers\FileController;

class CompanyController extends Controller
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
     * should get one specific category by id
     *
     * @return 200 {Object} - a json with one category
     * @return 404 - company not found
     */
    public function get($id) {
        // todo check if user is allowed to see this request // only admins or same company -/- or all
        // todo do not get all information from the user
        // todo list all jobs used in a company
        $company = Company::with(['user' => function ($q) {
                $q->select('id', 'firstname', 'lastname','job_id','company_id')
                    ->with(['job' => function ($q) {
                        $q->select('id', 'title');
                    }]);
            }])
            ->with('country')
            ->find($id);

        if (empty($company)) {
            return response()->json([
                'message' => 'Company not found',
            ], 404);
        }

        return response()->json($company->toArray());
    }

    /**
     * should get every company
     *
     * can be filtered by one or more jobs and countries
     *
     * @return 200 {Array} - within this array several single objects as company
     */
    public function getAll(Request $request) {
        // todo check if user is allowed to see this request // from all?
        // todo check if filter isset and apply

        // important http://stackoverflow.com/questions/23756858/laravel-eloquent-join-2-tables
        // todo if user works
        $companies = Company::with(['country' => function ($q) {
            $q->select('id', 'name');
        }])
            ->get();

        return response()->json($companies->toArray());
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

        $companies = Company::select('id', 'name')->get();

        return response()->json($companies->toArray());
    }
    /**
     * should create a new company
     *
     * @return 201 - company successfully created
     * @return 409 - company already exists
     */
    public function create(Request $request) {
        $this->validate($request, [
            'administrator' => 'required|integer',
            'name' => 'required|string',
            'logo_alt'=>'string',
            'fileUpload' => 'image',
            'country_id'=>'required|string',
            'city'=>'required|string',
            'address'=>'required|string',
            'phonenumber'=>'required|string',
            'email'=>'required|email',
            'Twitter'=>'string',
            'Facebook'=>'string',
            'LinkedIn'=>'string',

        ]);

        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        if ($user->role_id > 2) {
            // only admins
            return response()->json([
                    'message' => 'Creating companies is just available for admins'
                ], 401);
        }

        $exist = Company::where('name', $params['name'])->get();

        // check if there are name duplicates in name
        if (count($exist) != 0) {

            return response()->json([
                'message' => 'Categoryname already exist in the listed job or company',
                'company' => $exist
            ], 409);

        }

        // fileupload
        $file = new FileController($request);
        $fileMeta = $file->save('company', 'logo_alt', 1);

        // check, if not it will overwrite the database
        if ($fileMeta) {
            $params['logo_location'] = $fileMeta['filepath'];
        }

        $company = Company::create($params);

        return response()->json([
                'message' => 'Category successfully created',
                'category_id' => $company->id
            ], 201);
    }

    /**
     * updates a specific company by id
     *
     * @return 200 - successfully updated
     * @return 404 - company does not exist
     * @return 409 - companyname already exist
    */
    public function update(Request $request, $id) {
        $this->validate($request, [
            'administrator' => 'integer',
            'name' => 'string',
            'logo_alt'=>'string',
            'fileUpload' => 'image',
            'country_id'=>'string',
            'city'=>'string',
            'address'=>'string',
            'phonenumber'=>'string',
            'email'=>'email',
            'Twitter'=>'string',
            'Facebook'=>'string',
            'LinkedIn'=>'string',

       ]);

        // todo check if user is allowed to make this request // only admins
        $params = $request->all();
        $user = $this->auth->parseToken()->authenticate();

        if ($user->role_id == 4) {
            // normal
            return response()->json([
                    'message' => 'Updating companies is just available for admins and companyadmins'
                ], 401);
        } else if ($user->role_id == 3 && $user->company_id != $id) {
            // company admin && in another company
            return response()->json([
                    'message' => 'It is forbidden to update another company than your own.'
                ], 401);
        }

        $exist = Company::where('name', $params['name'])
            ->where('id','!=', $id)
            ->get();
        $company = Company::find($id);

        if (empty($company)) {
            return response()->json([
                'message' => 'Company does not exist',
            ], 404);
        }

        // check if there are name duplicates in name
        if (count($exist) != 0) {

            return response()->json([
                'message' => 'Categoryname already exist in the listed job or company',
                'company' => $exist
            ], 409);

        }

        // fileupload
        $file = new FileController($request);
        $fileMeta = $file->save('company', 'logo_alt', 1);

        // check, if not it will overwrite the database
        if ($fileMeta) {
            $params['logo_location'] = $fileMeta['filepath'];
        }

        $company = $company->update($params);

        return response()->json([
                'message' => 'Category successfully updated'
            ], 200);
    }

    /**
     * deletes a specific category by id
     *
     * @return 200 - successfully deleted
     * @return 404 - category does not exist
     */
    public function delete($id) {
        // todo check if there is an already
        // used user with this as foreign key
        // todo check if user is allowed to make this request // only superadmins
        $company = Company::find($id);
        $user = $this->auth->parseToken()->authenticate();

        if ($user->role_id > 1) {
            // only superadmins
            return response()->json([
                    'message' => 'Deleting companies is just available for superadmins'
                ], 401);
        }

        if ($company == NULL) {
            return response()->json([
                'message' => 'Company does not exist',
            ], 404);
        }

        $company->delete();

        return response()->json([
                'message' => 'Company successfully deleted',
            ], 200);
    }
}
