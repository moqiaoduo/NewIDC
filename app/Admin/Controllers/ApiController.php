<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServerGroup;
use App\Models\Service;
use App\Models\User;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function server_groups(Request $request)
    {
        $sp = $request->get('q');

        return ServerGroup::whereExists(function ($query) use ($sp) {
            $query->from('servers')->where('server_plugin', $sp)
                ->whereRaw("JSON_CONTAINS(server_groups.servers,concat('[\"',servers.id,'\"]'))");
        })->get(['id', "name as text"]);
    }

    public function users(Request $request)
    {
        $q = $request->get('q');
        return User::where('username', 'like', "%$q%")
            ->orWhere('email', 'like', "%$q%")->orWhere('id', $q)
            ->paginate(null, ['id', DB::raw("concat(username,' - #',id) as text")]);
    }

    public function services(Request $request)
    {
        $q = $request->get('q');
        return Service::where('services.name', 'like', "%$q%")
            ->leftJoin('products', function ($join) {
            $join->on('services.product_id', '=', 'products.id');
        })->orWhere('services.id', $q)->orWhere('user_id', $q)->paginate(null, ['services.id',
                DB::raw("concat(products.name, ' - ', services.name) as text")]);
    }
}
