<?php

namespace App\Events;

use App\Models\Ticket;

class TicketOpen extends TicketEvent
{
    public $admin;

    public function __construct(Ticket $ticket, $content, $admin)
    {
        $this->admin = $admin;

        parent::__construct($ticket, $content);
    }
}
