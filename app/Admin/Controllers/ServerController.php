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

        $grid->column('id', 'ID')->sortable();
        $grid->column('name', __('Name'))->sortable();
        $grid->column('usage',__('Usage'))->display(function () {
            return ($this->services_count??0).'/'.($this->max_load>0?$this->max_load:__('Unlimited'));
        });
        $grid->column('enable', __('Enable'))->bool();
        $grid->column('login',__('Login'))->display(function () {
            $class=$this->server_plugin;
            if (class_exists($class)) {
                $p=new $class;
                $p->init(null,null,$this);
                return $p->adminLogin();
            }
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Server::findOrFail($id));

        $show->field('id', 'ID');
        $show->field('name', __('Name'));
        $show->field('server_plugin', __('Server plugin'));
        $show->field('hostname', __('Hostname'));
        $show->field('ip', 'IP');
        $show->field('username', __('Username'));
        $show->field('password', __('Password'));
        $show->field('access_key', __('Access key'));
        $show->field('max_load', __('Max load'));
        $show->field('enable', __('Enable'));
        $show->field('api_access_address', __('Api access address'));
        $show->field('api_access_ssl', __('Api access ssl'));
        $show->field('access_ssl', __('Access ssl'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Server());

        $form->text('name', __('Name'));
        $form->text('hostname', __('Hostname'));
        $form->ip('ip', 'IP');
        $form->number('port',__('Port'))->help(__('admin.help.server.port'));
        $form->number('max_load', __('admin.server.max_load'))->min(0)
            ->help(__('admin.help.server.max_load'))->default(0);
        $form->url('status_address',__('admin.server.status_address'))
            ->help(__('admin.help.server.status_address'));
        $form->switch('enable', __('Enable'))->default(1);

        $form->divider(__('admin.server.detail'));
        $info=PluginManager::getList();
        foreach (PluginManager::getServerPluginList() as $plugin) {
            $plugins[$plugin]=$info[$plugin]['name']??$plugin;
        }
        $form->select('server_plugin', __('admin.server.plugin'))->required()
            ->options($plugins??[]);
        $form->text('username', __('Username'));
        $form->password('password', __('Password'));
        $form->textarea('access_key', __('admin.server.access_hash'))
            ->placeholder(__('admin.help.server.access_hash'));
        $form->radio('api_access_address', __('admin.server.api_access_address'))->required()
            ->options(['hostname'=>__('Hostname'),'ip'=>'IP'])->default('hostname')
            ->help(__('admin.help.server.api_access_address'));
        $form->switch('api_access_ssl', __('admin.server.api_access_ssl'))
            ->help(__('admin.help.server.api_access_ssl'));
        $form->switch('access_ssl', __('admin.server.access_ssl'))
            ->help(__('admin.help.server.access_ssl'));

        return $form;
    }
}
