<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware(['web', 'lang'])
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));

        Route::middleware(['web', 'auth', 'lang'])
            ->prefix('client')
            ->namespace($this->namespace . '\\Client')
            ->group(base_path('routes/client.php'));

        // 插件注册路由
        Route::middleware(['web', 'lang'])
            ->group(function () {
                $pages = \PluginManager::handler()->trigger($plugged)->plugin_page();

                if ($plugged) {
                    foreach ($pages as $slug => $p) {
                        foreach ($p as $page => $callable) {
                            Route::get("plugin/$slug/$page", $callable);
                        }
                    }
                }

                $pages = \PluginManager::handler()->trigger($plugged)->plugin_action();

                if ($plugged) {
                    foreach ($pages as $slug => $p) {
                        foreach ($p as $action => $callable) {
                            Route::post("plugin/$slug/$action", $callable)->name($slug . '_' . $action);
                        }
                    }
                }
            });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}
