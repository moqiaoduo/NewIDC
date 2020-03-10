<?php

namespace App\Admin\Controllers;

use App\Models\ProductGroup;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class ProductGroupController extends Controller
{
    protected $title = 'Product Groups';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ProductGroup());

        $grid->quickCreate(function (Grid\Tools\QuickCreate $create) {
            $create->text('name', __('Name'));
        });
        $grid->quickSearch('name');

        $grid->actions(function ($actions) {

            // 去掉查看
            $actions->disableView();
        });

        $grid->column('id', 'ID');
        $grid->column('name', __('Name'))->sortable();
        $grid->column('hide', __('Hide'))->switch()->filter([
            0 => '是',
            1 => '否',
        ])->sortable();
        $grid->column('created_at', __('Created at'))->sortable();
        $grid->column('updated_at', __('Updated at'))->sortable();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ProductGroup());

        $form->text('name', __('Name'))->required();
        $form->number('order', __('admin.sort_order'))->default(0)->required();
        $form->switch('hide', __('Hide'));

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });
        $form->footer(function (Form\Footer $footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
        });

        return $form;
    }
}
