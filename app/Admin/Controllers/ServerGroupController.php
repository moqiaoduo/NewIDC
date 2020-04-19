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

        $grid->column('id', 'ID');
        $grid->column('name', __('Name'));
        $grid->column('select_server_method', __('admin.server.select_server_method'))
            ->using(__('admin.server.fill_type'));
        $grid->column('servers', __('Servers'))->display(function ($servers) {
            return Server::findMany($servers)->implode('name',',');
        });
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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

        return $form;
    }
}
