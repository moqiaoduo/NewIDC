<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGroup;
use App\Models\ServerGroup;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products(Request $request)
    {
        $q = $request->get('q');
        return Product::where('name', 'like', "%$q%")->orWhere('id',$q)
            ->paginate(null, ['id', DB::raw("concat(name,' - #',id) as text")]);
    }

    public function product_groups(Request $request)
    {
        $q = $request->get('q');
        return ProductGroup::where('name', 'like', "%$q%")->orWhere('id',$q)
            ->paginate(null, ['id', "name as text"]);
    }

    public function server_groups(Request $request)
    {
        $sp = $request->get('q');

        return ServerGroup::whereExists(function ($query) use ($sp) {
            $query->from('servers')->where('server_plugin',$sp)
                ->whereRaw("JSON_CONTAINS(server_groups.servers,concat('[\"',servers.id,'\"]'))");
        })->get(['id', "name as text"]);
    }

    public function users(Request $request)
    {
        $q = $request->get('q');
        return User::where('username', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%")->orWhere('id',$q)
            ->paginate(null, ['id', DB::raw("concat(username,' - #',id) as text")]);
    }
}
