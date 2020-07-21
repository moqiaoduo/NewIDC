<?php

namespace App\Events;

use App\Models\Service;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServiceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Service
     */
    public $service;

    public $notify = true;

    /**
     * Create a new event instance.
     *
     * @param Service $service
     * @param bool $notify
     */
    public function __construct(Service $service, $notify = true)
    {
        $this->service = $service;
        $this->notify = $notify;
    }
}
