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

Route::get('/', function () {
    \App\User::create([
        'name' => 'Fulano',
        'email' => 'fulaninho@gmail.com',
        'password' => '12345678'
    ]);
    $users = \App\User::all();

    return view('welcome', compact('users'));
});
