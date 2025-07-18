<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'goal',
        'activity_level',
        'calories_target',
    ];

    protected $casts = [
        'calories_target' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function planDays()
    {
        return $this->hasMany(PlanDay::class);
    }

    // Add alias for compatibility with PlanResource
    public function days()
    {
        return $this->hasMany(PlanDay::class);
    }
} 