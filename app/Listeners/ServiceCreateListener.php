<?php

namespace App\Listeners;

use App\Events\ServiceCreate;
use App\Exceptions\ServiceCreateException;
use App\Models\Product;
use App\Models\Server;
use App\Models\Service;
use Arr;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
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
     * @return void
     * @throws ServiceCreateException
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
        $service->username = $this->generate_username(getOption('service_username_generation'), $domain);
        $service->password = encrypt(Str::random());
        $service->domain = $domain;
        if (($server_id = $this->pickServer($product)) == 0) {
            throw new ServiceCreateException(ServiceCreateException::NO_SERVER_AVAILABLE);
        }
        $service->server_id = $server_id;
    }

    private function generate_username($type, $domain = null)
    {
        $username = '';
        switch ($type) {
            case 'random':
                $username = Str::random(8);
                while (Service::where('username', $username)->exists()) {
                    $username = Str::random(8);
                }
                break;
            case 'domain':
                $domain = idn_to_ascii($domain);
                for ($i = 0; $i < strlen($domain); $i++) {
                    $ascii = ord($domain{$i});
                    if ($ascii >= 65 && $ascii <= 90 || $ascii >= 97 && $ascii <= 122)
                        $username .= $domain{$i};
                }
                // 假如提取不到任何英文字符，则采用随机生成
                if (empty($username)) $username = $this->generate_username('random');
        }
        return $username;
    }

    private function pickServer(Product $product, $method = null)
    {
        $servers = $product->server_group->servers;
        $method = is_null($method) ? $product->server_group->select_server_method : $method;
        switch ($method) {
            case 0:
                // TODO: 插件接管分配任务
                return $this->pickServer($product, 3);
            case 1:
                $min_count = 0; $min_server = 0;
                foreach (Server::findMany($servers) as $server) {
                    if ($server->services_count == 0) {
                        $min_server = $server->id;
                        break;
                    }
                    if ($min_count > $server->services_count) {
                        // 假如已经超限，那么就不能选
                        if ($server->max_load > 0 && $server->services_count >= $server->max_load) continue;
                        $min_count = $server->services_count;
                        $min_server = $server->id;
                    }
                }
                return $min_server;
            case 2:
                $max_count = 0; $max_server = 0;
                foreach (Server::findMany($servers) as $server) {
                    if ($max_count < $server->services_count) {
                        // 假如已经超限，那么就不能选
                        if ($server->max_load > 0 && $server->services_count >= $server->max_load) continue;
                        $max_count = $server->services_count;
                        $max_server = $server->id;
                    }
                }
                return $max_server;
            case 3:
                shuffle($servers);
                foreach (Server::findMany($servers) as $server) {
                    if ($server->max_load == 0 && $server->services_count < $server->max_load) break;
                }
                return $server->id ?? 0;
        }
        return 0;
    }
}
