<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::name("admin.")->prefix(config('admin.route.prefix'))->namespace(config('admin.route.namespace'))
    ->middleware(config('admin.route.middleware'))->group(function (Router $router) {

        $router->get('/', 'HomeController@index');
        $router->resource('product', 'ProductController');
        $router->resource('product_group', 'ProductGroupController');
        $router->resource('service','ServiceController');
        $router->resource('server','ServerController');
        $router->resource('server_group','ServerGroupController');
        $router->resource('user','UserController');
        $router->post('user/{id}/reset_password','UserController@reset_password')
            ->name('user.reset_success');
        $router->resource('ticket','TicketController');
        $router->resource('ticket_status','TicketStatusController');
        $router->resource('department','DepartmentController');

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
            $router->get('/server_groups','ApiController@server_groups');
            $router->get('/users','ApiController@users');
            $router->get('/price_table_tr/{name}/{id}', function ($name, $id) {
                return view('admin.price_table_tr', ['name' => $name, 'index' => $id]);
            });
        });

    });
