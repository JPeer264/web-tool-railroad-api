<?php 

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Company;
use App\Job;
use App\User;

class CompanyController extends Controller
{
    public function __construct() {
        $this->destinationPath = env('COMPANY_LOGO_PATH');
    }
    /**
     * should get one specific category by id
     *
     * @return 200 {Object} - a json with one category
     * @return 404 - company not found
     */
    public function get(Request $request, $id) {
        // todo do not get all information from the user
        // todo list all jobs used in a company
        $company = Company::with('user')->find($id);

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
        // todo janpeer check if filter isset and apply

        // important http://stackoverflow.com/questions/23756858/laravel-eloquent-join-2-tables
        // todo if user works 
        $params = $request->all();

        $companies = Company::get();

        // $filter = new Filter($companies, $request->all());

        // // filter by given parameters 
        // $filtered  = $filter->byParameters('job');

        return response()->json($companies->toArray());
    }

    /**
     * should create a new company
     *
     * @return 201 - company successfully created
     * @return 409 - company already exists
     */
    public function create(Request $request) {
        $params = $request->all();
        $exist = Company::where('name', $params['name'])->get();


        // check if there are name duplicates in name
        if (count($exist) != 0) {

            return response()->json([
                'message' => 'Categoryname already exist in the listed job or company',
                'company' => $exist
            ], 409); 

        }

        // $company = Company::create($params);

        if ($request->hasFile('logo')) {
            $request->file('logo')->move('Applications/XAMPP/xamppfiles/htdocs/web-tool-railroad-api/upload/compan');
        }

        return response()->json([
                'message' => 'Category successfully created',
                // 'category_id' => $company->id
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
        $params = $request->all();
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
    public function delete(Request $request, $id) {
        // todo check if there is an already
        // used user with this as foreign key
        $company = Company::find($id);

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
