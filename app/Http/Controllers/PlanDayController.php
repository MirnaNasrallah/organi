<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanDay;

class PlanDayController extends Controller
{
    /**
     * Display a listing of the plan days.
     */
    public function index()
    {
        $planDays = PlanDay::with(['plan', 'planItems.product'])->get();
        return response()->json($planDays);
    }
}
