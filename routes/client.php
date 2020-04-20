<?php

Route::get('/', 'IndexController@index')->name('index');
Route::get('/service', 'ServiceController@index');
Route::get('/service/{service}', 'ServiceController@detail')->name('service');
