<?php

namespace App\Utils;

use App\Events\ServiceUnsuspend;
use App\Jobs\ServiceActivate;
use App\Models\Product;
use App\Models\Server;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Str;
use App\Models\Service as Model;

class ServiceUtils
{
    public static function pickServer(Product $product, $method = null)
    {
        $server_ids = $product->server_group->servers;
        $method = is_null($method) ? $product->server_group->select_server_method : $method;
        switch ($method) {
            case 0:
                // TODO: 插件接管分配任务
                return self::pickServer($product, 3); // 现在临时用随机方式
            case 1:
                $servers = Server::find($server_ids);
                if (is_null($servers) || count($servers) == 0) return 0;    // 无服务器则返回0
                $first_server = $servers->first();
                $min_count = $first_server->services()->count();
                $min_server = $first_server->id;
                foreach ($servers as $server) {
                    if ($server->services()->count() == 0) {
                        $min_server = $server->id;
                        break;
                    }
                    if ($min_count > $server->services()->count()) {
                        // 假如已经超限，那么就不能选
                        if ($server->max_load > 0 && $server->services()->count() >= $server->max_load) continue;
                        $min_count = $server->services()->count();
                        $min_server = $server->id;
                    }
                }
                return $min_server;
            case 2:
                $max_count = 0; $max_server = 0;
                foreach (Server::findMany($server_ids) as $server) {
                    if ($max_count < $server->services()->count()) {
                        // 假如已经超限，那么就不能选
                        if ($server->max_load > 0 && $server->services()->count() >= $server->max_load) continue;
                        $max_count = $server->services()->count();
                        $max_server = $server->id;
                    }
                }
                return $max_server;
            case 3:
                shuffle($server_ids);
                foreach (Server::findMany($server_ids) as $server) {
                    if ($server->max_load == 0 || $server->services()->count() < $server->max_load) break;
                }
                return $server->id ?? 0;
        }
        return 0;
    }

    public static function generate_username($type, $product, $domain = null)
    {
        $username = '';
        switch ($type) {
            case 'random':
                $username = strtolower(Str::random(8));
                while (Model::where('username', $username)->whereIn('status', ['active', 'suspended'])
                    ->when(!getOption('site_service_username_unique'), function ($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })->exists()) {
                    $username = strtolower(Str::random(8));
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
                if (empty($username)) {
                    $username = self::generate_username('random', $product);
                } else {
                    $username = strtolower($username);
                    // 检测用户名是否存在，存在则增加随机字符
                    while (Model::where('username', $username)->whereIn('status', ['active', 'suspended'])
                        ->when(!getOption('site_service_username_unique'), function ($query) use ($product) {
                            $query->where('product_id', $product->id);
                        })->exists()) {
                        $username .= strtolower(Str::random(1));
                    }
                }
        }
        return $username;
    }

    public static function create(Product $product, User $user, $expire_at, $price, $data = [], $autoActivate = false)
    {
        $domain = $data['domain'] ?? null;

        $service = new Model();
        $service->product_id = $product->id;
        $service->user_id = $user->id;
        $service->name = Str::random();
        $service->username = self::generate_username(getOption('service_username_generation'), $product, $domain);
        $service->password = Str::random();
        $service->domain = $domain;
        $service->expire_at = $expire_at;
        $service->price = $price;
        $service->save();

        // 自动激活，激活工作由队列完成，防止拥塞
        if ($autoActivate) {
            ServiceActivate::dispatch($service);
        }

        return $service;
    }

    /**
     * 续期
     *
     * @param Model $service
     */
    public static function renew(Model $service)
    {
        $expire_at = Carbon::parse($service->expire_at);
        switch ($service->price['period']['unit']) {
            case 'day':
                $service->expire_at = $expire_at->addDays($service->price['period']['num']);
                break;
            case 'month':
                $service->expire_at = $expire_at->addMonths($service->price['period']['num']);
                break;
            case 'year':
                $service->expire_at = $expire_at->addYears($service->price['period']['num']);
                break;
            case 'unlimited':
                $service->expire_at = null; // null 表示无期限
                break;
            default:
                throw new \InvalidArgumentException('Unknown Period');
        }
        $service->save();
    }

    /**
     * 解除暂停
     *
     * @param Model $service
     */
    public static function unsuspend(Model $service)
    {
        $class = $service->server->server_plugin;
        if (class_exists($class)) {
            $plugin = new $class;
            /* @var \NewIDC\Plugin\Server $plugin */
            $plugin->init($service->product, $service, $service->server);
            $plugin->command('unsuspend');
            event(new ServiceUnsuspend($service));
        }
    }
}
