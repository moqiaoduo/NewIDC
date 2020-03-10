<?php

namespace App\Admin\Middleware;

use App;
use Closure;

class Lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 判断用户有没有登录和设置语言
        if (($user=$request->user('admin')) && $user->lang)
            App::setLocale($user->lang);
        return $next($request);
    }
}
