<?php

namespace App\Admin\Controllers;

use App\Models\Service;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ServiceController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '服务管理';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Service());

        $grid->column('id', __('Id'));
        $grid->column('product_id', __('Product id'));
        $grid->column('user_id', __('User id'));
        $grid->column('name', __('Name'));
        $grid->column('username', __('Username'));
        $grid->column('password', __('Password'));
        $grid->column('domain', __('Domain'));
        $grid->column('server_id', __('Server id'));
        $grid->column('status', __('Status'));
        $grid->column('expire_at', __('Expire at'));
        $grid->column('extra', __('Extra'));
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
        $show = new Show(Service::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('product_id', __('Product id'));
        $show->field('user_id', __('User id'));
        $show->field('name', __('Name'));
        $show->field('username', __('Username'));
        $show->field('password', __('Password'));
        $show->field('domain', __('Domain'));
        $show->field('server_id', __('Server id'));
        $show->field('status', __('Status'));
        $show->field('expire_at', __('Expire at'));
        $show->field('extra', __('Extra'));
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
        $form = new Form(new Service());

        $form->number('product_id', __('Product id'));
        $form->number('user_id', __('User id'));
        $form->text('name', __('Name'));
        $form->text('username', __('Username'));
        $form->password('password', __('Password'));
        $form->text('domain', __('Domain'));
        $form->number('server_id', __('Server id'));
        $form->text('status', __('Status'))->default('pending');
        $form->datetime('expire_at', __('Expire at'))->default(date('Y-m-d H:i:s'));
        $form->text('extra', __('Extra'));

        return $form;
    }
}
