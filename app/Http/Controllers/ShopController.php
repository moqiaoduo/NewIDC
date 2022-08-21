<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\Service;
use App\Utils\ServiceUtils;
use Auth;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $groups = ProductGroup::show()->orderBy('order')->get();
        if (!$groups->isEmpty()) $gid = $request->get('gid', $groups->first()->id);
        return view('shop', compact('groups', 'gid'))
            ->with('data', $groups->isEmpty()?[]:Product::show()->withGroup($gid)->get());
    }

    public function buyShow(Product $product)
    {
        $options = session()->pull('buy_options', []);

        return view('buy', compact('product', 'options') + ['guest' => Auth::guest()]);
    }

    public function buyCalc(Request $request, Product $product, $id)
    {
        if ($request->has('lang'))
            app()->setLocale($request->input('lang'));
        $price = $product->price[$id];
        $base = sprintf("%.2f", $price['price']);
        $total = sprintf("%.2f", $price['price'] + $price['setup']);
        $login = $request->input('login');
        return view('buy_calc', compact('product', 'base', 'price', 'total', 'login'));
    }

    public function buy(Request $request, Product $product)
    {
        if (Auth::guest()) {
            $request->session()->put('buy_options', $request->post());
            $request->session()->put('buy_id', $product->id);
            return redirect()->route('login');
        }
        $user = $request->user();
        $data = $request->post('extra', []);
        $price = $product->price[$request->get('period')];
        if ($product->require_domain) {
            if (empty($data['domain']))
                return back()->withErrors(['tip' => '要求提供域名']);
            if (Service::where('domain', $data['domain'])->whereIn('status', ['active', 'suspended'])
                ->when(!getOption('site_service_domain_unique'), function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists()) return back()->withErrors(['tip' => '域名已被占用']);
        }
        if (!$product->enable)
            return back()->withErrors(['tip' => '产品已下架']);
        if ($product->ena_stock && $product->stocks <= 0)
            return back()->withErrors(['tip' => '库存不足']);
        // TODO: 加入优惠码功能
        $pay = $price['price'];
        $ps = [
            'type' => $price['price'] > 0 ? 'pay' : 'free',
            'price' => $pay,
            'promotion_code' => '', // 优惠码待加
            'period' => [
                'name' => $price['name'],
                'num' => $price['period'],
                'unit' => $price['period_unit']
            ]
        ];
        if ($pay > 0) {
            // TODO: 加入账单功能
            // 当前暂不支持
            return back()->withErrors(['tip' => '暂不支持付费产品']);
        } else {
            if ($price['price'] == 0 &&
                ($free_limit = $product->price_configs['free_limit']) &&
                $user->services()->where('product_id', $product->id)->using()->count() >= $free_limit)
                return back()->withErrors(['tip' => '您已到达免费产品服务数量上限']);
            $period = $price['period'];
            switch ($price['period_unit']) {
                case 'day':
                    $expire = now()->addDays($period);
                    break;
                case 'month':
                    $expire = now()->addMonths($period);
                    break;
                case 'year':
                    $expire = now()->addYears($period);
                    break;
                case 'unlimited':
                    $expire = null; // null 表示无期限
                    break;
                default:
                    return back()->withErrors(['tip' => '未知周期']);
            }
            $service = ServiceUtils::create($product, $user, $expire, $ps, $data, $price['auto_activate']);
            if ($product->ena_stock) $product->decrement('stocks');
            return redirect()->route('service', $service);
        }
    }
}
