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
    ];

    protected $casts = [
        'total_calories' => 'decimal:2',
        'total_protein' => 'decimal:2',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function planItems()
    {
        return $this->hasMany(PlanItem::class);
    }
} 