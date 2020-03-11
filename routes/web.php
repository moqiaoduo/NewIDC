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

Auth::routes([
    'verify'=>getOption('email_verify',false),
    'register'=>getOption('register',true)
]);

Route::get('/', 'IndexController@index');

Route::get('/locale','IndexController@locale')->name('locale');
