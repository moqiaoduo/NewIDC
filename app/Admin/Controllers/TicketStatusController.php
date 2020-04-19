<?php

namespace App\Admin\Controllers;

use App\Models\TicketStatus;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class TicketStatusController extends Controller
{
    protected $title = 'Ticket Statuses';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TicketStatus());

        $grid->model()->orderBy('order', 'asc');
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });

        $grid->column('title', __('Title'))->sortable()->display(function ($title) {
            return '<span style="color: '.$this->color.';">'.$title.'</span>';
        });
        $grid->column('active', __('admin.ticket.active'))->switch();
        $grid->column('awaiting', __('admin.ticket.awaiting'))->switch();
        $grid->column('auto_close', __('admin.ticket.auto_close'))->switch();
        $grid->column('order', __('admin.sort_order'))->sortable();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TicketStatus());

        $form->text('title', __('Title'));
        $form->color('color',__('admin.ticket.status_color'));
        $form->switch('active', __('admin.ticket.active'));
        $form->switch('awaiting', __('admin.ticket.awaiting'));
        $form->switch('auto_close', __('admin.ticket.auto_close'));
        $form->number('order', __('admin.ticket.order'))
            ->default(($ts=TicketStatus::orderByDesc('order')->first())?$ts->order:0);
        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });
        $form->footer(function (Form\Footer $footer) {
            $footer->disableViewCheck();
        });

        return $form;
    }
}
