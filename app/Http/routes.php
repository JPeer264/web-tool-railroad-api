<?php

use App\Http\Controllers;

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

$app->group(['prefix' => 'api/v1','namespace' => 'App\Http\Controllers'], function($app) {
    // todo add specific method
    // @example UserController@method
    
    // user & register
    $app->post('register', 'UserController@register');
    $app->get('user', 'UserController@getAll');
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

    $app->get('category/{id}', 'CategoryController@get'); // created
    $app->post('category/{id}', 'CategoryController@update'); // created
    $app->delete('category/{id}', 'CategoryController@delete'); // created

    // topic
    $app->get('category/{id}/topic', 'TopicController@getAllByCategory'); // created
    $app->post('category/{id}/topic', 'TopicController@create'); // created

    $app->get('topic/{id}', 'TopicController@get'); // created 
    $app->post('topic/{id}', 'TopicController'); // created
    $app->delete('topic/{id}', 'TopicController'); // created

    // comment
    $app->post('topic/{id}/comment', 'CommentController@create');

    // todo add middleware to refresh token
    $app->post('refresh_token', function () use ($app) {
        return 'Should return a new token!';
    });
});

$app->get('test/{id}', 'UserController@index');