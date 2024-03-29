<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petticash extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'reason',
        'shift_id',
        'amount',
       
    ];

    public function shift()
    {
        return $this->belongsTo(Shift::class,'shift_id');
    }
}
