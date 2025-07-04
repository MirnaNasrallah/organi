<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with(['bmiRecords', 'plans', 'orders', 'wishlists', 'carts', 'payments'])->get();
        return response()->json($users);
    }
}
