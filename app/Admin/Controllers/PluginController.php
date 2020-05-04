<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;

class PluginController extends Controller
{
    public function index(Content $content)
    {
        $plugins = \PluginManager::getList();
        return $content
            ->title('插件管理')
            ->row(view('admin.plugin_list', compact('plugins')));
    }
}
