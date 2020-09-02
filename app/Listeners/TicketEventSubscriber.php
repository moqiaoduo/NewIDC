<?php

namespace App\Listeners;

use App\Events\TicketEvent;
use App\Models\User;
use App\Notifications\TicketAnswer;
use App\Notifications\TicketClose;
use App\Notifications\TicketCustomerReply;
use App\Notifications\TicketOpen;
use App\Notifications\TicketOpenAdmin;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TicketEventSubscriber
{
    public function handleOpen(TicketEvent $event)
    {
        try {
            foreach ($event->ticket->department->assign as $user_id) {
                User::findOrFail($user_id)->notify(new TicketOpenAdmin($event->ticket, $event->content));
            }
        } catch (ModelNotFoundException $e) {}
    }

    public function handleAnswer(TicketEvent $event)
    {
        $event->ticket->user->notify(new TicketAnswer($event->ticket, $event->content));
    }

    public function handleCustomerReply(TicketEvent $event)
    {
        try {
            foreach ($event->ticket->department->assign as $user_id) {
                User::findOrFail($user_id)->notify(new TicketCustomerReply($event->ticket, $event->content));
            }
        } catch (ModelNotFoundException $e) {}
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
