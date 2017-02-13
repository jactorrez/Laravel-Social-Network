<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/',  function () {
    return view('welcome');
})->name('home');


Route::post('/signup', 'UserController@postSignUp');
Route::post('/signin', 'UserController@postSignIn');


Route::get('/dashboard', [ 
	'uses' => 'PostController@getDashboard', 
	'middleware' => 'auth'
	])->name('dashboard');

Route::post('/post', [
	'uses' => 'PostController@storePost',
	'as' => 'post.create'
]);

Route::get('/delete/{id}', [
	'uses' => 'PostController@deletePost',
	'as' => 'post.delete'
]);

Route::get('/logout', [
	'uses' => 'UserController@logout',
	'as' => 'logout'
]);

Route::post('/edit', 'PostController@editPost')->name('edit');

Route::get('/account', [
	'uses' => 'UserController@getAccount',
	'as' => 'account',
	'middleware' => 'auth'
]);

Route::post('/updateaccount', [
	'uses' => 'UserController@updateAccount',
	'as' => 'account.save',
	'middleware' => 'auth'
]);

Route::get('/userimage/{filename}', [
	'uses' => 'UserController@getUserImage',
	'as' => 'account.image',
	'middleware' => 'auth'
]);


Route::post('/like', [
	'uses' => 'PostController@likePost',
	'as' => 'like',
	'middleware' => 'auth'
]);