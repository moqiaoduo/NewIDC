<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Utils\ServiceUtils;
use DB;
use Illuminate\Http\Request;
use NewIDC\Plugin\Server;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status') ?: $request->cookie('service.status');
        cookie('service.status', $status);
        $data = $request->user()->services()
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })->with('product')->with('product.group')->get();
        return view('client.service.index', compact('data', 'status'));
    }

    public function detail(Service $service)
    {
        $login = '';
        if (($server = $service->server) && class_exists($class = $server->server_plugin)) {
            $plugin = new $class;
            /* @var Server $plugin */
            $plugin->init($service->product, $service, $server);
            $login = $plugin->userLogin();
        }
        return view('client.service.detail', compact('service', 'login'));
    }

    public function changePassword(Request $request, Service $service)
    {
        $request->validate([
            'password' => 'required|confirmed'
        ]);

        $class = $service->server->server_plugin;
        if (class_exists($class)) {
            $plugin = new $class;
            /* @var \NewIDC\Plugin\Server $plugin */
            $plugin->init($service->product, $service, $service->server);
            $result = $plugin->command('change_password', $request->post('password'));
            if ($result['code'] === 0) return back()->with('success', '修改成功');
        }
        return back()->withErrors(['change_password' => $result['msg'] ?? '未知原因']);
    }

    public function renew(Service $service)
    {
        $disable = is_null($service->expire_at) || in_array($service->status, ['pending', 'cancelled', 'terminated']);
        $free = $service->price['type'] === 'free';
        $limit_days = $service->product->price_configs['free_limit_days'];
        $free_renew = $limit_days == 0 || now()->addDays($limit_days) > $service->expire_at;
        return view('client.service.renew', compact('service', 'free', 'free_renew',
            'disable', 'limit_days'));
    }

    public function renew_submit(Service $service)
    {
        $free = $service->price['type'] === 'free';
        $limit_days = $service->product->price_configs['free_limit_days'];
        $free_renew = $limit_days == 0 || now()->addDays($limit_days) > $service->expire_at;
        if (is_null($service->expire_at) ||
            in_array($service->status, ['pending', 'cancelled', 'terminated']) ||
            $free && !$free_renew) return '该服务无法续费';
        DB::beginTransaction();
        try {
            if ($free) {
                ServiceUtils::renew($service);
            } else {
                // TODO: 生成账单
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return 'Something broken';
        }
        if ($service->expire_at > now() && $service->status == 'suspended') {
            ServiceUtils::unsuspend($service);
        }
        return <<<HTML
<script>
parent.window.location.reload()
</script>
HTML;

    }
}
