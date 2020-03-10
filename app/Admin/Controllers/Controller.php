<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\AdminController;
use Lang;

class Controller extends AdminController
{
    public function __construct()
    {
        $that=&$this;
        $this->middleware(function ($request, $next) use (&$that) {
            $text = 'admin.titles.'.str_replace(['-',' '],'_',strtolower($that->title));
            if (Lang::has($text)) $that->title = __($text);
            return $next($request);
        });
    }
}
