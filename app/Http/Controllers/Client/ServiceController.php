<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->user()->services()
            ->when($status = $request->get('status'), function ($query) use ($status) {
            $query->where('status', $status);
        })->with('product')->with('product.group')->get();
        return view('client.service.index',compact('data'));
    }

    public function detail(Service $service)
    {

    }
}
