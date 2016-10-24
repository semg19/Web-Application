<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Start
Route::get('/', function () {
    return view ('welcome');
});

//Authentication
Auth::routes();

//Roles
Route::get('/admin', ['uses' => 'HomeController@getAdminPage', 'as' => 'roles.admin', 'middleware' => 'roles', 'roles' => ['Admin']]);
Route::post('/adminassign', ['uses' => 'HomeController@postAdminAssignRoles', 'as' => 'admin.assign']);
Route::post('/toggle', 'HomeController@toggle');
Route::get('/account', ['uses' => 'HomeController@getAccount', 'as' => 'account']);
Route::put('/updateaccount', ['uses' => 'HomeController@postSaveAccount', 'as' => 'account.save']);

//Application
Route::get('/home', 'HomeController@index');
Route::get('forum', ['uses' => 'ForumController@index', 'as' => 'forum.index', 'middleware' => 'roles', 'roles' => ['Admin', 'Author', 'User']]);
Route::get('forum/{id}', ['uses' => 'ForumController@show', 'as' => 'forum.show', 'middleware' => 'roles', 'roles' => ['Admin', 'Author', 'User']]);

//Posts
Route::resource('posts', 'PostController');
Route::resource('categories', 'CategoryController', ['except' => ['create']]);
Route::resource('tags', 'TagController', ['except' => ['create']]);

//Comments
Route::post('comments/{post_id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store', 'middleware' => 'roles', 'roles' => ['Author', 'User']]);
Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit', 'middleware' => 'roles', 'roles' => ['Author', 'User']]);
Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update', 'middleware' => 'roles', 'roles' => ['Author', 'User']]);
Route::delete('comments/{id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy', 'middleware' => 'roles', 'roles' => ['Admin', 'Author', 'User']]);
Route::get('comments/{id}/delete', ['uses' => 'CommentsController@delete', 'as' => 'comments.delete', 'middleware' => 'roles', 'roles' => ['Admin', 'Author', 'User']]);
