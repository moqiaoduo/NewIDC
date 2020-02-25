<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGroup;
use DB;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products(Request $request)
    {
        $q = $request->get('q');
        return Product::where('name', 'like', "%$q%")->orWhere('id',$q)
            ->paginate(null, ['id', DB::raw("concat(name,'(PID:',id,')') as text")]);
    }

    public function product_groups(Request $request)
    {
        $q = $request->get('q');
        return ProductGroup::where('name', 'like', "%$q%")->orWhere('id',$q)
            ->paginate(null, ['id', DB::raw("concat(name,'(GID:',id,')') as text")]);
    }
}
