<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_id',
        'day_number',
        'total_calories',
        'total_protein',
        'total_carbs',
        'total_fat',
    ];

    protected $casts = [
        'total_calories' => 'decimal:2',
        'total_protein' => 'decimal:2',
        'total_carbs' => 'decimal:2',
        'total_fat' => 'decimal:2',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function planItems()
    {
        return $this->hasMany(PlanItem::class);
    }

    // Add alias for compatibility with PlanResource
    public function items()
    {
        return $this->hasMany(PlanItem::class);
    }
} 