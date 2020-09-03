<?php

namespace App\Listeners;

use App\Events\TicketEvent;
use App\Models\Administrator;
use App\Notifications\TicketAnswer;
use App\Notifications\TicketClose;
use App\Notifications\TicketCustomerReply;
use App\Notifications\TicketOpen;
use App\Notifications\TicketOpenAdmin;
use Notification;

class TicketEventSubscriber
{
    public function handleOpen(TicketEvent $event)
    {
        $event->ticket->user->notify(new TicketOpen($event->ticket, $event->content));

        if (!$event->admin) {
            Notification::route('mail', $event->ticket->department->email)
                ->notify(new TicketOpenAdmin($event->ticket, $event->content));
        }
    }

    public function handleAnswer(TicketEvent $event)
    {
        $event->ticket->user->notify(new TicketAnswer($event->ticket, $event->content));
    }

    public function handleCustomerReply(TicketEvent $event)
    {
        Notification::send($event->ticket->department->email, new TicketCustomerReply($event->ticket, $event->content));
    }

    public function handleClose(TicketEvent $event)
    {
        $event->ticket->user->notify(new TicketClose($event->ticket));
    }

    public function subscribe($events)
    {
        $events->listen(
            'App\Events\TicketOpen',
            self::class . '@handleOpen'
        );

        $events->listen(
            'App\Events\TicketAnswer',
            self::class . '@handleAnswer'
        );

        $events->listen(
            'App\Events\TicketCustomerReply',
            self::class . '@handleCustomerReply'
        );

        $events->listen(
            'App\Events\TicketClose',
            self::class . '@handleClose'
        );
    }
}
