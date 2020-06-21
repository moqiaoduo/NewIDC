<?php

namespace App\Admin\Controllers;

use App\Models\Server;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use PluginManager;

class ServerController extends Controller
{
    protected $title = 'Servers';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Server());

        $grid->quickSearch('name');
        $grid->disableFilter();

        $grid->column('name', __('Name'))->sortable();
        $grid->column('usage', __('Usage'))->display(function () {
            return ($this->services_count ?? 0) . '/' . ($this->max_load > 0 ? $this->max_load : __('Unlimited'));
        });
        $grid->column('enable', __('Enable'))->bool()->sortable()->filter([
            1 => '是',
            0 => '否',
        ]);
        $grid->column('login', __('Login'))->display(function () {
            $class = $this->server_plugin;
            if (class_exists($class)) {
                $p = new $class;
                $p->init(null, null, $this);
                return $p->adminLogin();
            }
        });

        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Server());

        $form->text('name', __('Name'))->required();
        $form->text('hostname', __('Hostname'));
        $form->ip('ip', 'IP');
        $form->text('port', __('Port'))->help(__('admin.help.server.port'));
        $form->number('max_load', __('admin.server.max_load'))->min(0)
            ->help(__('admin.help.server.max_load'))->default(0);
        $form->url('status_address', __('admin.server.status_address'))
            ->help(__('admin.help.server.status_address'));
        $form->switch('enable', __('Enable'))->default(1);

        $form->divider(__('admin.server.detail'));
        foreach (PluginManager::getServerPluginList() as $slug=>$plugin) {
            $plugins[$plugin] = PluginManager::getPluginInfo($slug)['name'] ?? $plugin;
        }
        $form->select('server_plugin', __('admin.server.plugin'))->required()
            ->options($plugins ?? []);
        $form->text('username', __('Username'));
        $form->password('password', __('Password'));
        $form->textarea('access_key', __('admin.server.access_hash'))
            ->placeholder(__('admin.help.server.access_hash'));
        $form->radio('api_access_address', __('admin.server.api_access_address'))->required()
            ->options(['hostname' => __('Hostname'), 'ip' => 'IP'])->default('hostname')
            ->help(__('admin.help.server.api_access_address'));
        $form->switch('api_access_ssl', __('admin.server.api_access_ssl'))
            ->help(__('admin.help.server.api_access_ssl'));
        $form->switch('access_ssl', __('admin.server.access_ssl'))
            ->help(__('admin.help.server.access_ssl'));

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });
        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
        });

        return $form;
    }
}
