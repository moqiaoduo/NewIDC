<?php

namespace App\Listeners;

use App\Events\ServiceTerminate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ServiceTerminateListener
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
     * @param  ServiceTerminate  $event
     * @return void
     */
    public function handle(ServiceTerminate $event)
    {
        //
    }

    public function shouldQueue(ServiceTerminate $event)
    {
        return $event->order->subtotal >= 5000;
    }
}
