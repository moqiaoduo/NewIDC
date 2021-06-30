<?php

namespace App\Jobs;

use App\Exceptions\ServiceCreateException;
use App\Models\Server;
use App\Models\Service;
use App\Utils\ServiceUtils;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ServiceActivate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Service
     */
    private $service;

    /**
     * Create a new job instance.
     *
     * @param Service $service
     */
    public function __construct(Service $service)
    {
        $this->service = $service;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws ServiceCreateException
     */
    public function handle()
    {
        $service = $this->service;
        $product = $service->product;

        if (($server_id = ServiceUtils::pickServer($product)) == 0) {
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
            $result = $plugin->command('create');
            if ($result['code'] == 0)
                event(new \App\Events\ServiceActivate($service));
        }
    }
}
