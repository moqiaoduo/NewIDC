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

        $grid->disableFilter();

        $grid->actions(function ($actions) {

            // 去掉查看
            $actions->disableView();
        });

        $grid->column('name', __('Name'))->sortable()->expand(function ($model) {
            $form = new Form($model);

            $form->setAction(route('admin.product_group.update', $model));

            $form->tools(function (Form\Tools $tools) {
                // 去掉`列表`按钮
                $tools->disableList();

                // 去掉`删除`按钮
                $tools->disableDelete();

                // 去掉`查看`按钮
                $tools->disableView();
            });
            $form->footer(function (Form\Footer $footer) {
                // 去掉`查看`checkbox
                $footer->disableViewCheck();

                // 去掉`继续编辑`checkbox
                $footer->disableEditingCheck();

                // 去掉`继续创建`checkbox
                $footer->disableCreatingCheck();
            });

            $form->text('name', __('Name'))->required();
            $form->number('order', __('admin.sort_order'))->default(0)->required();

            return $form->edit($model->id)->render();
        });
        $grid->column('hide', __('Hide'))->switch()->filter([
            0 => '是',
            1 => '否',
        ])->sortable();

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
