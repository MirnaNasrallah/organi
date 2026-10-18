<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Support\Facades\Auth;

class ShopController extends Controller
{
    public function shopIndex()
    {
        $products = product::all();

        return view('shop.shopContent', compact('products'));
    }

    public function shopIndexLow()
    {
        $products = product::all();

        return view('shop.shopContentLow', compact('products'));
    }

    public function shopIndexHigh()
    {
        $products = product::all();

        return view('shop.shopContentHigh', compact('products'));
    }

    public function shopIndexPlan()
    {
        $products = product::all();
        $user = Auth::user();

        return view('shop.shopContentPlan', compact('products', 'user'));
    }

    public function mainPageindex()
    {
        return view('mainPage');
    }

    public function searchIndex()
    {
        $keyword = request('search-input');
        $products = product::where('product_name', 'LIKE', '%'.$keyword.'%')
            ->orWhere('description', 'LIKE', '%'.$keyword.'%')
            ->orWhere('price', 'LIKE', '%'.$keyword.'%')
            ->get();

        return view('shop.shopContent', compact('products'));
    }
}
