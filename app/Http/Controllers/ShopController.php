<?php

namespace App\Http\Controllers;

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
        $price = $product->price[$request->get('period')];
        // TODO: 加入优惠码功能
        $pay = $price['price'];
        if ($pay > 0) {
            // TODO: 加入账单功能
        } else {

        }


        dd($request->post(), $product);
    }
}
