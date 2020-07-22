<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;

class PluginController extends Controller
{
    public function index(Content $content)
    {
        \PluginManager::updatePluginVersion();
        $plugins = \PluginManager::getList();
        return $content
            ->title('插件管理')
            ->row(view('admin.plugin_list', compact('plugins')));
    }

    public function enableOrDisablePlugin(Request $request)
    {
        $enables = \PluginManager::getEnableList();
        $plugin = $request->post('plugin');

        if ($request->post('enable')) {
            if (in_array($plugin, $enables)) return back();

            $enables[] = $plugin;
        } else {
            if (($key = array_search($plugin, $enables))===false) return back();

            unset($enables[$key]);
            $enables = array_merge($enables);
        }

        setOption('ena_plugins', json_encode($enables));

        return back();
    }
}
