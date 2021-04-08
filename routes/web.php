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

Route::get('/{any}', function () {
//    dd(parse_url("postgres://rheokifiiodlwe:2162e299ab49adce86f93cf16e9a6bd0cf95393e114d326cf6d885469ab3b7af@ec2-52-70-15-120.compute-1.amazonaws.com:5432/dcq9jdf0qicisd"));

    return view('app');
})->where('any', '.*');

Route::post('/register', 'Auth\RegisterController@create');

Route::post('/login', 'Auth\LoginController@login');

Route::post('/logout', 'Auth\LoginController@logout');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
