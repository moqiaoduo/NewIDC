<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function products(Request $request)
    {
        $q = $request->get('q');
        return Product::where('name', 'like', "%$q%")->paginate(null, ['id', 'name as text']);
    }
}
