<?php

namespace App\Listeners;

use App\Events\ServiceActivate;
use App\Exceptions\ServiceCreateException;
use App\Models\Server;
use App\Utils\Service;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param ServiceActivate $event
     * @return mixed
     * @throws ServiceCreateException
     */
    public function handle(ServiceActivate $event)
    {
        $service = $event->getService();
        $product = $service->product;

        if (($server_id = Service::pickServer($product)) == 0) {
            throw new ServiceCreateException(ServiceCreateException::NO_SERVER_AVAILABLE);
        }
        $service->server_id = $server_id;
        $service->save();

        $server = Server::findOrFail($server_id);
        $plugin = $server->server_plugin;
        if (class_exists($plugin)) {
            /* @var \NewIDC\Plugin\Server $plugin */
            $plugin = new $plugin();
            $plugin->init($product, $service, $server);
            $result = $plugin->changeServiceStatusTo('active');
            if ($result['code'] !== 0) {
                return $result;
            }
        }
        return null;
    }

    public function shouldQueue(ServiceActivate $event)
    {
        return $event->isBackground();
    }
}
