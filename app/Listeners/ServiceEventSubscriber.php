<?php

namespace App\Listeners;

use App\Events\ServiceActivate;
use App\Events\ServiceSuspend;
use App\Events\ServiceTerminate;
use App\Events\ServiceUnsuspend;
use Illuminate\Contracts\Queue\ShouldQueue;

class ServiceEventSubscriber implements ShouldQueue
{
    public function handleActivate(ServiceActivate $event)
    {
        $service = $event->service;
        $service->user->notify(new \App\Notifications\ServiceActivate($service));
    }

    public function handleSuspend(ServiceSuspend $event)
    {
        $service = $event->service;
        $service->user->notify(new \App\Notifications\ServiceSuspend($service));
    }

    public function handleUnsuspend(ServiceUnsuspend $event)
    {
        $service = $event->service;
        $service->user->notify(new \App\Notifications\ServiceUnsuspend($service));
    }

    public function handleTerminate(ServiceTerminate $event)
    {
        $service = $event->service;
        $service->user->notify(new \App\Notifications\ServiceTerminate($service));
    }

    public function subscribe($events)
    {
        $events->listen(
            ServiceActivate::class,
            self::class . '@handleActivate'
        );

        $events->listen(
            ServiceSuspend::class,
            self::class . '@handleSuspend'
        );

        $events->listen(
            ServiceUnsuspend::class,
            self::class . '@handleUnsuspend'
        );

        $events->listen(
            ServiceTerminate::class,
            self::class . '@handleTerminate'
        );
    }
}
