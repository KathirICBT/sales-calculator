<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petticash extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'petty_cash_reason_id',
        'shift_id',
        'amount',
       
    ];

    public function pettyCashReason()
    {
        return $this->belongsTo(PettyCashReason::class,'petty_cash_reason_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class,'shift_id');
    }


}
