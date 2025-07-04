<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BMIRecord;

class BMIRecordController extends Controller
{
    /**
     * Display a listing of the BMI records.
     */
    public function index()
    {
        $bmiRecords = BMIRecord::with('user')->get();
        return response()->json($bmiRecords);
    }
}
