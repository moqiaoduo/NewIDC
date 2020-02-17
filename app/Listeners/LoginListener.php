<?php

namespace App\Listeners;

use Illuminate\Auth\Events\LoginEvent;

class LoginListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle($event)
    {
        $user=$event->user;
        $user->last_logon_at=now();
        $user->save();
    }
}
