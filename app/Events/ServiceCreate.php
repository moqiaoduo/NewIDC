<?php

namespace App\Events;

use App\Models\Product;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ServiceCreate
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Product
     */
    private $product;

    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $data;

    /**
     * @var bool
     */
    private $autoActivate;

    private $expire_at;

    private $price;

    /**
     * Create a new event instance.
     *
     * @param Product $product
     * @param User $user
     * @param $expire_at
     * @param array $extra
     * @param bool $autoActivate
     */
    public function __construct(Product $product, User $user, $expire_at, $price, $extra = [], $autoActivate = false)
    {
        $this->product = $product;
        $this->user = $user;
        $this->data = $extra;
        $this->autoActivate = $autoActivate;
        $this->expire_at = $expire_at;
        $this->price = $price;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isAutoActivate(): bool
    {
        return $this->autoActivate;
    }

    /**
     * @return mixed
     */
    public function getExpireAt()
    {
        return $this->expire_at;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }
}
