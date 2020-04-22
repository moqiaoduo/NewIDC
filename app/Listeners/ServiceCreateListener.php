<?php

namespace App\Listeners;

use App\Events\ServiceActivate;
use App\Events\ServiceCreate;
use App\Models\Service;
use Str;

class ServiceCreateListener
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
     * @param ServiceCreate $event
     * @return Service
     */
    public function handle(ServiceCreate $event)
    {
        $data = $event->getData();
        $domain = $data['domain'] ?? null;
        $product = $event->getProduct();

        $service = new Service();
        $service->product_id = $product->id;
        $service->user_id = $event->getUser()->id;
        $service->name = Str::random();
        $service->username = \App\Utils\Service::generate_username(getOption('service_username_generation'), $domain);
        $service->password = encrypt(Str::random());
        $service->domain = $domain;
        $service->expire_at = $event->getExpireAt();
        $service->price = $event->getPrice();
        $service->save();

        // 自动激活，激活工作由另一个监听器完成
        if ($event->isAutoActivate())
            event(new ServiceActivate($service));

        return $service;
    }
}
