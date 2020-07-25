<?php

namespace App\Admin\Controllers;

use App\Models\TicketStatus;
use App\Utils\Ticket;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Lang;

class TicketStatusController extends Controller
{
    protected $title = 'Ticket Statuses';

    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index(Content $content)
    {
        return redirect()->route('admin.ticket_status.create');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TicketStatus());

        $grid->setResource(route('admin.ticket_status.index'));

        $grid->model()->orderBy('order', 'asc');
        $grid->actions(function ($actions) {
            // 去掉查看
            $actions->disableView();
        });

        $grid->column('title', __('Title'))->sortable()->display(function ($title) {
            $origin = $title;
            $title = Ticket::titleTrans($origin);
            if ($origin != $title) $title .= '(' . $origin . ')';
            return '<a><span style="color: '.$this->color.';">'.$title.'</span></a>';
        });
        $grid->column('active', __('admin.ticket.active'))->using(usingList());
        $grid->column('awaiting', __('admin.ticket.awaiting'))->using(usingList());
        $grid->column('auto_close', __('admin.ticket.auto_close'))->using(usingList());
        $grid->column('order', __('admin.sort_order'))->sortable();

        $grid->header(function ($query) {
            return '标题会自动翻译为当前语言设置好的文本，若无翻译则会使用原来的文本。若要使用翻译，原文本必须为英文。' .
                '若应用翻译，则标题旁会在括号内显示原文本。'; // TODO 国际化
        });

        return $grid;
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['create'] ?? trans('admin.create'))
            ->body($this->grid())
            ->body($this->form());
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->description($this->description['edit'] ?? trans('admin.edit'))
            ->body($this->grid())
            ->body($this->form()->edit($id));
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
            // 去掉`列表`按钮
            $tools->disableList();
            // 去掉`查看`按钮
            $tools->disableView();
        });
        $form->footer(function (Form\Footer $footer) {
            $footer->disableViewCheck();

            $footer->checkEditing();
        });

        return $form;
    }
}
