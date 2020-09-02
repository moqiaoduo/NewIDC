<?php

namespace App\Events;

use App\Models\Ticket;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TicketEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ticket;

    public $content;

    /**
     * Create a new event instance.
     *
     * @param Ticket $ticket
     * @param string $content
     */
    public function __construct(Ticket $ticket, $content = '')
    {
        $this->ticket = $ticket;

        $this->content = $content;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('ticket-' . $this->ticket->id);
    }
}
