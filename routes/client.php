<?php

Route::get('/', 'IndexController@index')->name('client');
Route::get('/service', 'ServiceController@index')->name('services');
Route::get('/service/{service}', 'ServiceController@detail')->name('service');
Route::post('/service/{service}/change_pwd', 'ServiceController@changePassword')
    ->name('service.change_pwd');
Route::get('/service/{service}/renew', 'ServiceController@renew')->name('service.renew');
Route::post('/service/{service}/renew', 'ServiceController@renew_submit');
