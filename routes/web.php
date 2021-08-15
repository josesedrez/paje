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

Route::get('change-password/{user}', 'UserController@changePassword');

Route::get('/{any}', function () {
//    dd(parse_url("postgres://rheokifiiodlwe:2162e299ab49adce86f93cf16e9a6bd0cf95393e114d326cf6d885469ab3b7af@ec2-52-70-15-120.compute-1.amazonaws.com:5432/dcq9jdf0qicisd"));

    return view('app');
})->where('any', '.*');

Route::middleware('crypton')->post('/register', 'Auth\RegisterController@create');

Route::middleware('crypton')->post('/login', 'Auth\LoginController@login');

Route::post('/logout', 'Auth\LoginController@logout');

Route::post('/forgot-password-send-email', 'UserController@forgotPasswordSendEmail');

Route::post('/change-profile', 'UserController@changeProfile');

Route::post('/get-csrf', 'FormController@getCsrfToken');

Route::middleware('crypton')->post('/load-cover', 'GameController@loadCover');

Route::post('/user-evaluations-count', 'UserController@getUserEvaluationsCount');

// USERS
Route::middleware('crypton')->post('/current-user', 'UserController@getCurrentUser');

Route::post('/all-users', 'UserController@getAllUsers');

Route::middleware('crypton')->post('/edit-user-name', 'UserController@editName');

Route::middleware('crypton')->post('/edit-user-email', 'UserController@editEmail');

Route::middleware('crypton')->post('/edit-user-password', 'UserController@editPassword');

// EVALUATIONS
Route::post('/all-evaluations', 'EvaluationController@getAllEvaluations');

Route::post('/add-evaluation', 'EvaluationController@addNewEvaluation');

Route::post('/delete-evaluation', 'EvaluationController@deleteEvaluation');

Route::post('/edit-evaluation', 'EvaluationController@editEvaluation');

// GAMES
Route::post('/all-games', 'GameController@getAllGames');

Route::middleware('crypton')->post('/add-game', 'GameController@addNewGame');

Route::middleware('crypton')->post('/delete-game', 'GameController@deleteGame');

Route::middleware('crypton')->post('/edit-game', 'GameController@editGame');

Route::post('/edit-game-categories', 'GameController@editGameCategories');

// CATEGORIES
Route::middleware('crypton')->post('/all-categories', 'CategoryController@getAllCategories');

Route::middleware('crypton')->post('/add-category', 'CategoryController@addNewCategory');

Route::middleware('crypton')->post('/delete-category', 'CategoryController@deleteCategory');

Route::middleware('crypton')->post('/edit-category', 'CategoryController@editCategory');

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

//URL::forceScheme('https');
