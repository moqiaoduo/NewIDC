<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Ticket;
use App\Models\TicketStatus;
use Illuminate\Http\Request;
use App\Utils\Ticket as TicketUtils;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TicketController extends Controller
{
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
        return view('client.ticket.create')->with('services', $request->user()->services)
            ->with('departments', Department::where('hide', 0)->get());
    }

    public function show(Ticket $ticket)
    {
        if ($ticket->user_id != \Auth::id()) throw new NotFoundHttpException();

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

        $ticket = TicketUtils::create($request, $request->user()->id);

        if (!$ticket) return back();

        return redirect()->route('ticket.show', $ticket);
    }

    public function update(Request $request, $id)
    {
        if (!$request->user()->tickets()->where('id', $id)->exists()) throw new NotFoundHttpException();

        TicketUtils::reply($request, $id, $request->user()->id);

        return back();
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->update(['status' => 6]);

        return redirect()->route('ticket.index');
    }
}
