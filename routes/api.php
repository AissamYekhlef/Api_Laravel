<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// all routes / api here must be api authenticated
Route::group([
    // to use v1 version 1 from the api
    'prefix' => 'v1'
],function(){



Route::group([
    'middleware' => ['api', 'checkPassword', 'changeLanguage'], 
    'namespace'=>'Api'
], function () {
    Route::post('get-all', 'CategoriesController@index');
    Route::post('get-main-cat', 'CategoriesController@getMainCat');
    Route::post('get-cat-id', 'CategoriesController@getCategoryByID');
    Route::post('change-cat-status', 'CategoriesController@changeStatus');
    
    Route::group([
        'prefix'=>'admin',
        'namespace'=>'Admin'
    ],function(){
        Route::post('login','AuthController@login');
        Route::post('logout','AuthController@logout');
        Route::post('me','AuthController@me');
        Route::post('refresh','AuthController@refresh');
        Route::post('once','AuthController@once');
    });
});


Route::group([
    'prefix' => 'trans',
],function(){
    Route::get('get','TranslateController@index');
    Route::get('get/{translate}','TranslateController@show');
    Route::get('search','TranslateController@search');

    // How need admin-api
    Route::post('update/{translate}','TranslateController@update');
    Route::post('add','TranslateController@store');
    Route::post('add_list','TranslateController@store_list');
    Route::delete('delete/{translate}','TranslateController@destroy');
});


});