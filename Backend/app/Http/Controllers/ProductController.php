<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with(['category', 'orderItems', 'planItems', 'wishlists', 'carts'])->get();
        return response()->json($products);
    }
}
