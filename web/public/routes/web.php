<?php

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

Route::group(['middleware' => 'user-auth'], function () {
    Route::get('/', 'UserController@getTodoList');
    Route::get('/logout', 'UserController@logout');
});

Route::get('/register', function () {
    return view('pages.register');
});

Route::get('/login', function () {
    return view('pages.login');
});

//Route::post('/register', ['before' => 'csrf', 'UserController@register']);
Route::post('/register', 'UserController@register');
Route::post('/login', 'UserController@login');