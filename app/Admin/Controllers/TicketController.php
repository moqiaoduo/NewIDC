<?php

namespace App\Admin\Controllers;

use App\Models\{Department, Ticket, TicketDetail, TicketStatus, User};
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\{
    Form,
    Grid,
    Show
};
use Lang;

class TicketController extends Controller
{
    protected $title = 'Tickets';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Ticket());

        $grid->column('id', __('ID'));
        $grid->column('user', __('User'));
        $grid->column('title', __('Title'));
        $grid->column('status', __('Status'));
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
        $show = new Show(Ticket::findOrFail($id));

        $show->field('id', __('ID'));
        $show->field('user_id', __('User id'));
        $show->field('title', __('Title'));
        $show->field('status', __('Status'));
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
        $form = new Form(new Ticket());

        $form->select('user_id', __('User'))->options(function ($id) {
            if ($id && $user=User::find($id))
                return [$user->id=>$user->username .' - #'. $user->id];
        })->ajax('/admin/api/users')->required();
        $form->select('department_id',__('Department'))->required()
            ->options(Department::all()->pluck('name','id'));
        $form->select('priority',__('Priority'))->options([
            'low'=>__('Low'),'medium'=>__('Medium'),'high'=>__('High')
        ])->required();
        $form->text('title', __('Title'))->required();
        $tsf=$form->select('status', __('Status'))->required();
        foreach (TicketStatus::orderBy('order')->get() as $ts) {
            $default_ts = $default_ts??$ts['id'];
            if (Lang::has($tsn='ticket.status.'.str_replace(['-',' '],'_',strtolower($ts['title'])))) {
                $tss[$ts['id']] = Lang::get($tsn);
            } else {
                $tss[$ts['id']] = __($ts['title']);
            }
        }
        if (isset($default_ts)) $tsf->default($default_ts);
        if (isset($tss)) $tsf->options($tss);
        if ($form->isCreating())
            $form->editor('content',__('Content'))->required();

        return $form;
    }

    public function store()
    {
        \request()->validate([
            'user_id'       => 'required|numeric',
            'department_id' => 'required|numeric',
            'priority'      => 'required',
            'title'         => 'required|string|max:255',
            'content'       => 'required'
        ]);
        $ticket=Ticket::create([
            'user_id'       => \request()->post('user_id'),
            'title'         => \request()->post('title'),
            'department_id' => \request()->post('department_id'),
            'priority'      => \request()->post('priority'),
            'status'        => 2
        ]);
        TicketDetail::create([
            'user_id'   => \request()->user('admin')->id,
            'ticket_id' => $ticket->id,
            'content'   => clean(\request()->post('content')),
            'admin'     => true
        ]);
        return redirect(\request()->post('_previous_'));
    }
}
