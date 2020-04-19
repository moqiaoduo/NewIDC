<?php

namespace App\Admin\Controllers;

use App\Models\Department;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class DepartmentController extends AdminController
{
    protected $title = 'Department';

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
        $grid->column('email', __('Email'));
        $grid->column('hide', __('Hide'))->switch();
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
        $show = new Show(Department::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('description', __('Description'));
        $show->field('email', __('Email'));
        $show->field('assign', __('Assign'));
        $show->field('client_only', __('Client only'));
        $show->field('hide', __('Hide'));
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
        $form = new Form(new Department());

        $form->text('name', __('Name'));
        $form->textarea('description', __('Description'));
        $form->email('email', __('Email'));
        $form->text('assign', __('Assign'));
        $form->switch('client_only', __('Client only'));
        $form->switch('hide', __('Hide'));

        return $form;
    }
}
