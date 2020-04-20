<?php

namespace App\Listeners;

use App\Events\ServiceActivate;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ServiceActivateListener implements ShouldQueue
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
     * @param  ServiceActivate  $event
     * @return void
     */
    public function handle(ServiceActivate $event)
    {
        //
    }

    public function shouldQueue(ServiceActivate $event)
    {
        return $event->isBackground();
    }
}
