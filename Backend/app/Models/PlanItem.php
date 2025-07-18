<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_day_id',
        'product_id',
        'quantity',
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
    ];

    public function planDay()
    {
        return $this->belongsTo(PlanDay::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
} 