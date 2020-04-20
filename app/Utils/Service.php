<?php

namespace App\Utils;

use App\Models\Product;
use App\Models\Server;
use Str;

class Service
{
    public static function pickServer(Product $product, $method = null)
    {
        $servers = $product->server_group->servers;
        $method = is_null($method) ? $product->server_group->select_server_method : $method;
        switch ($method) {
            case 0:
                // TODO: 插件接管分配任务
                return self::pickServer($product, 3); // 现在临时用随机方式
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

    public static function generate_username($type, $domain = null)
    {
        $username = '';
        switch ($type) {
            case 'random':
                $username = Str::random(8);
                while (\App\Models\Service::where('username', $username)->exists()) {
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
                if (empty($username)) {
                    $username = self::generate_username('random');
                } else {
                    // 检测用户名是否存在，存在则
                    while (\App\Models\Service::where('username', $username)->exists()) {
                        $username = Str::random(8);
                    }
                }
        }
        return $username;
    }
}
