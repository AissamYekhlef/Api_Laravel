<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => 'api', 'namespace'=>'Api'], function () {
    Route::get('get-main-cat', 'CategoriesController@index');
    // Route::get('get-main-cat', function(){
    //     return 'Hello Api ';
    // });
});
