<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'subscription_status',
        'expires_at',
        'weight',
        'height',
        'age',
        'gender',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'expires_at' => 'datetime',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'age' => 'integer',
        'password' => 'hashed',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function bmiRecords()
    {
        return $this->hasMany(BMIRecord::class);
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function cart()
    {
        return $this->hasMany(Cart::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isPremium()
    {
        return $this->role === 'premium' && 
               $this->subscription_status === 'active' && 
               $this->expires_at > now();
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
