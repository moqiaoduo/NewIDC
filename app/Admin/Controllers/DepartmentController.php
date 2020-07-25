<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DepartmentController extends Controller
{
    protected $title = 'Departments';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Department());

        $grid->column('name', __('Name'))->sortable();
        $grid->column('description', __('Description'))->limit(200);
        $grid->column('hide', __('Hide'))->switch();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $form = new Form(new Department());

        $form->text('name', __('Name'))->required();
        $form->textarea('description', __('Description'));
        $form->listbox('assign', __('admin.department.assign'))->options(Administrator::all()->pluck('name', 'id'))
            ->help(__('admin.department.assign_help'));
        $form->switch('client_only', __('admin.department.client_only'))->default(true)
            ->help(__('admin.department.client_only_help'));
        $form->switch('hide', __('Hide'));

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
