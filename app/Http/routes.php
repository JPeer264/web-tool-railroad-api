<?php

use App\Http\Controllers;
use App\Http\Controllers\AuthenticationController;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1',
        'namespace' => 'App\Http\Controllers',
        'middleware' => 'App\Http\Middleware\Authenticate'], function($app) {
    // todo add specific method
    // @example UserController@method

    $app->get('user', 'UserController@getAll');
    // user & register
    $app->get('user/{id}', 'UserController@get');
    $app->post('user/{id}', 'UserController@update');
    $app->delete('user/{id}', 'UserController@delete');

    // job
    $app->get('job', 'JobController@getAll'); // created
    $app->post('job', 'JobController@create'); // created

    $app->get('job/{id}', 'JobController@get'); // created
    $app->post('job/{id}', 'JobController@update'); // created
    $app->delete('job/{id}', 'JobController@delete'); // created

    // company
    $app->get('company', 'CompanyController@getAll'); // created
    $app->post('company', 'CompanyController@create'); // created

    $app->get('company/{id}', 'CompanyController@get'); // created
    $app->post('company/{id}', 'CompanyController@update'); // created
    $app->delete('company/{id}', 'CompanyController@delete'); // created

    // category
    $app->get('category', 'CategoryController@getAll'); // created
    $app->post('category', 'CategoryController@create'); // created

    // $app->get('category/{id}', 'CategoryController@get'); // do we show single categories?
    $app->post('category/{id}', 'CategoryController@update'); // created
    $app->delete('category/{id}', 'CategoryController@delete'); // created

    // subcategory
    $app->get('subcategory', 'SubcategoryController@getAll'); // created
    $app->post('category/{id}/subcategory', 'SubcategoryController@create'); // created

    $app->get('subcategory/{id}', 'SubcategoryController@get'); // created
    $app->post('subcategory/{id}', 'SubcategoryController@update'); // created
    $app->delete('subcategory/{id}', 'SubcategoryController@delete'); // created

    // topic
    $app->get('subcategory/{id}/topic', 'TopicController@getAllByCategory'); // created
    $app->post('subcategory/{id}/topic', 'TopicController@create'); // created

    $app->get('topic/{id}', 'TopicController@get'); // created
    $app->post('topic/{id}', 'TopicController@update'); // created
    $app->delete('topic/{id}', 'TopicController@delete'); // created

    // comment
    $app->post('topic/{id}/comment', 'CommentController@create');

    $app->post('type', 'TypeController@create'); // created
    $app->get('type/{id}', 'TypeController@get'); // created
    $app->post('type/{id}', 'TypeController'); // created
    $app->delete('type/{id}', 'TypeController@delete'); // created


});

$app->group(['prefix' => 'api/v1',
        'namespace' => 'App\Http\Controllers'], function($app) {

    $app->post('auth/token', 'AuthenticationController@authenticate');
    $app->post('register', 'UserController@register');
    $app->post('register/{invite_token}', 'UserController@registerInvite');


});
