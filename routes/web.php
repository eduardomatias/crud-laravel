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

 /** Index */
Route::get('/', function() {	
  return redirect('login');
});

/** Login */
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

/** Necessário autenticação */
Route::group(['middleware' => 'auth'], function() {
    
    /** Usuários */
    Route::group(['prefix' => 'users'], function() {
        /** Alterar senha */
        Route::get('password', 'UserController@editPassword')->name('users.password');
        Route::post('password', 'UserController@updatePassword')->name('users.password');
    });
    Route::resource('users', 'UserController');
    
});