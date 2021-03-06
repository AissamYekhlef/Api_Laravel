<?php
// use Illuminate\Routing\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', function () {
    return view('welcome');
});

Route::get('/lang', function () {
    return app()->getLocale();
});
Route::get('/lang/ar', function () {
    app()->setLocale('ar');
    return app()->getLocale();
});