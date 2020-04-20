<?php

namespace App\Http\Controllers;

use App\Events\ServiceCreate;
use App\Exceptions\ServiceCreateException;
use App\Models\Product;
use App\Models\Service;
use Auth;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        return view('shop');
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
        $login = $request->get('login');
        $price = $product->price[$id];
        $base = sprintf("%.2f", $price['price']);
        $total = sprintf("%.2f", $price['price'] + $price['setup']);
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
        $price = $product->price[$request->get('period')];
        if (!$product->enable)
            return back()->withErrors('产品已下架', 'tip');
        if ($product->ena_stock && $product->stocks <= 0)
            return back()->withErrors('库存不足', 'tip');
        // TODO: 加入优惠码功能
        $pay = $price['price'];
        if ($pay > 0) {
            // TODO: 加入账单功能
            // 当前暂不支持
            return back()->withErrors('暂不支持非免费产品', 'tip');
        } else {
            if ($price['price'] == 0 &&
                ($free_limit = $product->price_configs['free_limit']) &&
                $user->services()->where('product_id',$product->id)->using()->count() >= $free_limit)
                return back()->withErrors('您已到达免费产品服务数量上限', 'tip');
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
                    return back()->withErrors('未知周期', 'tip');
            }
            [$service] = event(new ServiceCreate($product, $user, $expire, $request->post('extra', []),
                $price['auto_activate']));
            if ($product->ena_stock) $product->decrement('stocks');
            return redirect()->route('service', $service);
        }
    }
}
