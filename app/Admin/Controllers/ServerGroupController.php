<?php

namespace App\Admin\Controllers;

use App\Models\Server;
use App\Models\ServerGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ServerGroupController extends Controller
{
    protected $title = 'Server Groups';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ServerGroup());

        $grid->quickSearch('name');

        $grid->column('name', __('Name'))->sortable();
        $grid->column('select_server_method', __('admin.server.select_server_method'))
            ->using(__('admin.server.fill_type'))->sortable()->filter(__('admin.server.fill_type'));
        $grid->column('servers', __('Servers'))->display(function ($servers) {
            return Server::findMany($servers)->implode('name',',');
        });

        $grid->disableFilter();

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
        $form = new Form(new ServerGroup());

        $form->text('name', __('Name'))->required();
        $form->radio('select_server_method',__('admin.server.select_server_method'))
            ->options(__('admin.server.fill_type'))->default(1);
        $form->listbox('servers', __('Servers'))->options(Server::all()->pluck('name','id'));

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
