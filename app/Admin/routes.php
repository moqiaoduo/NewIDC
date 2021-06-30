<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'as'            => 'admin.',
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    $router->resource('product', 'ProductController');
    $router->resource('product_group', 'ProductGroupController');
    $router->resource('service', 'ServiceController');
    $router->any('service/{service}/command/{command?}', 'ServiceController@serverCommand')
        ->name('service.command');
    $router->post('service/create/next/{step}', function (\Illuminate\Http\Request $request, $step) {
        $data = $request->all();
        unset($data['_token']);
        $data['step'] = $step;
        return redirect(route('admin.service.create', $data));
    })->name('service.create.next');
    $router->resource('server', 'ServerController');
    $router->resource('server_group', 'ServerGroupController');
    $router->resource('user', 'UserController');
    $router->post('user/{id}/reset_password', 'UserController@reset_password')
        ->name('user.reset_success');
    $router->get('user/{user}/login', 'UserController@login');
    $router->resource('ticket', 'TicketController');
    $router->post('/ticket/{ticket}/reply', 'TicketController@reply')->name('ticket.reply');
    $router->resource('ticket_status', 'TicketStatusController');
    $router->resource('department', 'DepartmentController');

    $router->group([
        'as'        => 'config.',
        'prefix'    => 'config'
    ], function (Router $router) {
        $router->get("/", 'ConfigController@index')->name('base');
        $router->post('/', 'ConfigController@save');
        $router->get('/cron', 'ConfigController@cron')->name('cron');
        $router->get('/upload', 'ConfigController@upload')->name('upload');
        $router->get('/template', 'ConfigController@template')->name('template');
        $router->fallback('ConfigController@third_part');
    });

    $router->group([
        'as'        => 'plugin.',
        'prefix'    => 'plugin'
    ], function (Router $router) {
        $router->get('/', 'PluginController@index');
        $router->post('/manage', 'PluginController@enableOrDisablePlugin')->name('manage');
    });

    $router->group(['prefix' => "/api"], function (Router $router) {
        $router->get('/server_groups', 'ApiController@server_groups');
        $router->get('/users', 'ApiController@users');
        $router->get('/services', 'ApiController@services');
        $router->get('/price_table_tr/{name}', function ($name) {
            return view('admin.price_table_tr', ['name' => $name, 'index' => Str::random(32)]);
        });
    });
});
