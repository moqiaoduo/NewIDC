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

class ServiceActivate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Service
     */
    private $service;

    private $background;

    /**
     * Create a new event instance.
     *
     * @param Service $service
     * @param bool $background
     */
    public function __construct(Service $service, $background = true)
    {
        $this->service = $service;
        $this->background = $background;
    }

    /**
     * @return Service
     */
    public function getService(): Service
    {
        return $this->service;
    }

    /**
     * @return bool
     */
    public function isBackground(): bool
    {
        return $this->background;
    }
}
