<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::name("admin.")->prefix(config('admin.route.prefix'))->namespace(config('admin.route.namespace'))
    ->middleware(config('admin.route.middleware'))->group(function (Router $router) {

        $router->get('/', 'HomeController@index');
        $router->resource('product', 'ProductController');
        $router->resource('product_group', 'ProductGroupController');

        $router->name('config.')->prefix('/config')->group(function (Router $router) {
            $router->get("/",'ConfigController@index')->name('base');
            $router->post('/','ConfigController@save');
            $router->get('/cron','ConfigController@cron')->name('cron');
            $router->get('/template','ConfigController@template')->name('template');
            $router->fallback('ConfigController@third_part');
        });

        $router->group(['prefix'=>"/api"],function (Router $router) {
            $router->get('/products','ApiController@products');
            $router->get('/product_groups','ApiController@product_groups');
        });

    });
