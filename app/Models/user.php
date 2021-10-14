<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\user as Authenticatable;

class user extends Authenticatable
{
    protected $fillable = ['name','email','password'];
    use HasFactory;
}
