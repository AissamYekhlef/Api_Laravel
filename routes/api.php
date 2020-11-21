<?php


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
    'middleware' => ['api', 'checkPassword', 'changeLanguage'], 
    'namespace'=>'Api'
], function () {
    Route::post('get-all', 'CategoriesController@index');
    Route::post('get-main-cat', 'CategoriesController@getMainCat');
    Route::post('get-cat-id', 'CategoriesController@getCategoryByID');
    Route::post('change-cat-status', 'CategoriesController@changeStatus');
    
    Route::group([
        // 'middleware' => '',
        'prefix'=>'admin',
        'namespace'=>'Admin'
    ],function(){
        Route::post('login','AuthController@login');
        Route::post('logout','AuthController@logout');
        Route::post('me','AuthController@me');
        Route::post('refresh','AuthController@refresh');
    });
});



// Route::group(['middleware' => ['api', 'checkPassword', 'changeLanguage', 'checkAdminToken:admin-api'], 'namespace'=>'Api'], function () {
//     Route::post('admin/c', 'CategoriesController@index');
// });
