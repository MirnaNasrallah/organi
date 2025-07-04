<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the carts.
     */
    public function index()
    {
        $carts = Cart::with(['user', 'product'])->get();
        return response()->json($carts);
    }
}
