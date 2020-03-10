<?php

namespace App\Http\Controllers;

use Cookie;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function locale(Request $request)
    {
        if ($request->has('lang')) {
            if ($user=$request->user())
                $user->update('lang');
            $cookie=Cookie::make('language',$request->get('lang'));
        }
        return back()->cookie($cookie??null);
    }
}
