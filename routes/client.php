<?php

Route::get('/', 'IndexController@index')->name('index');
Route::get('/service', 'ServiceController@index')->name('services');
Route::get('/service/{service}', 'ServiceController@detail')->name('service');
