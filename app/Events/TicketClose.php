<?php

namespace App\Events;

use App\Models\Ticket;

class TicketClose extends TicketEvent
{
    public $admin;

    public function __construct(Ticket $ticket, $admin = false)
    {
        $this->admin = $admin;

        parent::__construct($ticket);
    }
}
