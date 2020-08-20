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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//ACL==================================================================================================
Route::get('user/{user}/roles', 'UserController@roles')->name('user.roles');
Route::put('user/{user}/roles', 'UserController@rolesSync')->name('user.roles');
Route::resource('user', 'UserController');

Route::get('role/{role}/permissions', 'RoleController@permissions')->name('role.permissions');
Route::put('role/{role}/permissions', 'RoleController@permissionsSync')->name('role.permissions');
Route::resource('role', 'RoleController');

Route::resource('permission', 'PermissionController');
//======================================================================================================

Route::get('/post', 'PostController@index')->name('post.index')->middleware(['role_or_permission:Listar Artigo|Administrador']);
Route::get('/post/create', 'PostController@create')->name('post.create');
Route::post('/post', 'PostController@store')->name('post.store');
Route::match(['put', 'patch'], '/post/{post}', 'PostController@update')->name('post.update');
Route::get('/post/{post}', 'PostController@show')->name('post.show');
Route::delete('/post/{post}', 'PostController@destroy')->name('post.destroy');
Route::get('/post/{post}/edit', 'PostController@edit')->name('post.edit');