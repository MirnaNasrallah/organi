<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;

class WishlistController extends Controller
{
    /**
     * Display a listing of the wishlists.
     */
    public function index()
    {
        $wishlists = Wishlist::with(['user', 'product'])->get();
        return response()->json($wishlists);
    }
}
