<?php

namespace App\Console\Commands;

use App\Events\ServiceSuspend;
use App\Events\ServiceTerminate;
use App\Models\Service;
use Illuminate\Console\Command;

class ServiceExpireProcessor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process expired services';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $options = getOptions(['suspend', 'terminate', 'suspend_days', 'terminate_days']);
        Service::whereIn('status', ['active', 'suspending'])
            ->chunkById(100, function ($services) use ($options) {
            foreach ($services as $service) {
                /* @var Service $service */

                if (is_null($service->expire_at)) continue; // 无期限服务不需要处理

                if (now()->subDays($options['terminate_days']) > $service->expire_at &&
                    $options['terminate']) {
                    // 当服务到销毁期限时
                    $class = $service->server->server_plugin;
                    if (!class_exists($class)) continue;
                    $plugin = new $class;
                    /* @var \NewIDC\Plugin\Server $plugin */
                    $plugin->init($service->product, $service, $service->server);
                    $result = $plugin->command('terminate');
                    if ($result['code']) {
                        $this->warn("Terminate Service {$service->id} Fail: {$result['msg']}");
                        continue;
                    }
                    event(new ServiceTerminate($service));
                } elseif ($service->status == 'active' &&
                    now()->subDays($options['suspend_days']) > $service->expire_at) {
                    // 当服务到暂停期限且还未暂停时
                    event(new ServiceSuspend($service));

                    if ($options['suspend']) {
                        $class = $service->server->server_plugin;
                        if (!class_exists($class)) continue;
                        $plugin = new $class;
                        /* @var \NewIDC\Plugin\Server $plugin */
                        $plugin->init($service->product, $service, $service->server);
                        $result = $plugin->command('suspend');
                        if ($result['code']) {
                            $this->warn("Suspend Service {$service->id} Fail: {$result['msg']}");
                        }
                    }
                }

                // 续费恢复的逻辑写到续费里面了，所以这里不会检测，以免某些情况下误解除暂停
            }
        });

        return 0;
    }
}
