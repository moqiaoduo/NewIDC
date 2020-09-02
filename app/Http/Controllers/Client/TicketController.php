<?php

namespace App\Http\Controllers\Client;

use App\Events\TicketClose;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use App\Utils\Ticket as TicketUtils;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['create', 'store', 'show', 'update']);
    }

    public function index(Request $request)
    {
        $status = $request->get('status');
        return view('client.ticket.index')
            ->with('data', $request->user()->tickets()->when($status > 0, function ($query) use ($status) {
                $query->where('status', $status);
            })->get())->with('ticket_statuses', TicketStatus::orderBy('order')->get())->with('status', $status);
    }

    public function create(Request $request)
    {
        $user = $request->user();

        $view = view('client.ticket.edit');

        if ($user) {
            $view->with('services', $user ? $user->services : [])
                ->with('name', $user->username)->with('email', $user->email);
            $departments = Department::where('hide', 0)->get();
        } else {
            $departments = Department::where('hide', 0)
                ->where('client_only', 0)->get();
            $view->with('name', old('name'))->with('email', old('email'));
        }

        $step = $request->get('step', count($departments) > 1 ? 1 : 2);

        return $step == 2 ?
            $view->with('deptid', $request->get('deptid'))->with('departments', $departments) :
            view('client.ticket.create')->with('departments', $departments);
    }

    public function show(Request $request, Ticket $ticket)
    {
        if ($ticket->user_id != \Auth::id() || $ticket->user_id == 0 && $ticket->check_code != $request->get('c'))
            throw new NotFoundHttpException();

        return view('client.ticket.show', compact('ticket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_id' => 'required|numeric',
            'priority' => 'required',
            'title' => 'required|string|max:255'
        ]);

        if (empty(strip_tags($request->post('content'))))
            return back()->withErrors(['content' => '内容不能为空'])->withInput();

        $user = $request->user();

        $ticket = TicketUtils::create($request, $user ? $user->id : 0); // 若未登录，则user_id=0

        if (!$ticket) return back();

        return redirect()->route('ticket.show', ['ticket' => $ticket, 'c' => $ticket->check_code]);
    }

    public function update(Request $request, $id)
    {
        if ($user = $request->user()) {
            $exist = $request->user()->tickets()->where('id', $id)->exists();
        } else {
            $exist = Ticket::where('check_code', $request->post('check_code'))
                ->where('id', $id)->exists();
        }

        if (!$exist) throw new NotFoundHttpException();

        TicketUtils::reply($request, $id, $user ? $user->id : 0);

        return back();
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->update(['status' => 6]);

        event(new TicketClose($ticket));

        return redirect()->route('ticket.index');
    }
}
