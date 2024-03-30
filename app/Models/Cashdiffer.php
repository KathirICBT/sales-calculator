<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cashdiffer extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'cashdifference',
        'shift_id',
    ];

    

    

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
