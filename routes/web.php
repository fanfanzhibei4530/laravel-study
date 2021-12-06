<?php

use Illuminate\Support\Facades\Route;

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
    view()->addExtension("html", "php");
    return view()->file(public_path().'/template/client/dist/index.html');
});

Route::get('/test', 'TestController@index');

Route::get('/test/upload', 'TestController@upload');
Route::post('/test/uploads', 'TestController@uploadHandle');

Route::get('/user', 'UserController@index');

Route::prefix('admin')->middleware(['auth.admin'])->group(function () {
    Route::get('/', 'Admin\IndexController@index');



    Route::get('/login', 'Admin\LoginController@index');
    Route::post('/login/login', 'Admin\LoginController@login');
});