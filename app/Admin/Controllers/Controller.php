<?php

namespace App\Admin\Controllers;

use App\Models\ProductGroup;
use App\Models\Server;
use App\Models\ServerGroup;
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

    public function makeProductGroups()
    {
        $groups = [];
        foreach (ProductGroup::with('products')->get() as $group) {
            $groups[] = ['label' => $group->name, 'options' => $group->products->pluck('name', 'id')];
        }
        return $groups;
    }

    public function makeServerGroups()
    {
        $groups = [];
        foreach (ServerGroup::all() as $group) {
            $servers = Server::findMany($group->servers);
            $groups[] = ['label' => $group->name, 'options' => $servers->pluck('name', 'id')];
        }
        return $groups;
    }
}
