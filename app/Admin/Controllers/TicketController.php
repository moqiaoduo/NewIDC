<?php

namespace App\Admin\Controllers;

use App\Models\{Department, Service, Ticket, TicketDetail, TicketStatus, User};
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\{Form, Grid, Layout\Column, Layout\Content, Layout\Row, Show, Widgets\Box};
use Illuminate\Http\Request;
use Lang;
use Storage;
use App\Utils\Ticket as TicketUtils;

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
        $grid->column('user', __('User'))->display(function ($user) {
            return '<a href="' . route('admin.user.show', $user['id']) . '">' . $user['username'] . '</a>';
        });
        $grid->column('title', __('Title'))->display(function ($user) {
            return '<a href="' . route('admin.ticket.show', $this) . '">' . $user . '</a>';
        });
        $grid->column('status', __('Status'))->display(function () {
            return '<a><span style="color: ' . $this->status_color . ';">' . $this->status_text . '</span></a>';
        })->sortable();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        return $grid;
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        $ticket = Ticket::findOrFail($id);
        return $content
            ->title($this->title())
            ->description(__('admin.ticket.reply'))
            ->body(function (Row $row) use ($ticket) {
                $row->column(3, function (Column $column) use ($ticket) {
                    $column->row(view('admin.ticket.status', compact('ticket')));
                });
                $row->column(9, function (Column $column) use ($ticket) {
                    $form = new \Encore\Admin\Widgets\Form($ticket);

                    $form->action(route('admin.ticket.reply', $ticket));

                    $form->editor('content', __('Content'))->required();
                    $form->multipleFile('files', __('Attachments'))
                        ->help("支持的文件格式：" . implode(",", array_filter(
                                json_decode(getOption('allow_upload_ext'), true))));

                    $column->row((new Box('回复', $form))->collapsable());

                    $column->row(view('admin.ticket.dialog')->with('data', $ticket->contents()
                        ->orderByDesc('created_at')->get()));
                });
            });
    }

    public function reply(Request $request, $id)
    {
        TicketUtils::reply($request, $id, $request->user('admin')->id, true);

        return redirect()->route('admin.ticket.show', $id);
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
            if ($id && $user = User::find($id))
                return [$user->id => $user->username . ' - #' . $user->id];
        })->ajax('/admin/api/users')->required();
        $form->select('department_id', __('Department'))->required()
            ->options(Department::all()->pluck('name', 'id'));
        $form->select('service_id', __('admin.ticket.service'))->options(function ($id) {
            if ($id && $service = Service::find($id))
                return [$service->id => $service->name . ' - #' . $service->id];
        })->ajax('/admin/api/services');
        $form->select('priority', __('Priority'))->options([
            'low' => __('Low'), 'medium' => __('Medium'), 'high' => __('High')
        ])->required()->default('medium');
        $form->text('title', __('Title'))->required();
        $tsf = $form->select('status', __('Status'))->required();

        foreach (TicketStatus::orderBy('order')->get() as $ts) {
            $default_ts = $default_ts ?? $ts['id'];
            $tss[$ts['id']] = TicketUtils::titleTrans($ts['title']);
        }

        if (isset($default_ts)) $tsf->default($default_ts);
        if (isset($tss)) $tsf->options($tss);
        if ($form->isCreating()) {
            $form->editor('content', __('Content'))->required();
            $form->multipleFile('files', __('Attachments'));
        }

        return $form;
    }

    public function store()
    {
        $request = \request();
        $request->validate([
            'user_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'priority' => 'required',
            'title' => 'required|string|max:255',
            'content' => 'required'
        ]);

        TicketUtils::create($request, $request->post('user_id'), true, $request->user('admin')->id);

        return redirect($request->post('_previous_'));
    }
}
