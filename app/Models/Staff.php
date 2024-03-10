<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Staff extends Authenticatable
{
    use HasFactory;
    protected $table = 'staffs';
    protected $fillable = [
        'staff_name',
        'phonenumber',
        'username',
        'password',
    ];
}
