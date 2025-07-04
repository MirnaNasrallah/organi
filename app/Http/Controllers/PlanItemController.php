<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanItem;

class PlanItemController extends Controller
{
    /**
     * Display a listing of the plan items.
     */
    public function index()
    {
        $planItems = PlanItem::with(['planDay', 'product'])->get();
        return response()->json($planItems);
    }
}
