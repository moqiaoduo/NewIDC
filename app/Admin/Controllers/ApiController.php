<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductGroup;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products(Request $request)
    {
        $q = $request->get('q');
        return Product::where('name', 'like', "%$q%")->where('id',$q)
            ->paginate(null, ['id', 'name as text']);
    }

    public function product_groups(Request $request)
    {
        $q = $request->get('q');
        return ProductGroup::where('name', 'like', "%$q%")->where('id',$q)
            ->paginate(null, ['id', 'name as text']);
    }
}
