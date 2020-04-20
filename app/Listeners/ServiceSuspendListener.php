<?php

namespace App\Listeners;

use App\Events\ServiceSuspend;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ServiceSuspendListener
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
     * @param  ServiceSuspend  $event
     * @return void
     */
    public function handle(ServiceSuspend $event)
    {
        //
    }

    public function shouldQueue(ServiceSuspend $event)
    {
        return $event->order->subtotal >= 5000;
    }
}
