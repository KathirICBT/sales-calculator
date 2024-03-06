<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentsale extends Model
{
    use HasFactory;
    protected $fillable = [
        'paymentmethod_id',
        'amount',
    ];

    public function paymentMethod()
    {
        return $this->belongsTo(Paymentmethod::class,'paymentmethod_id');
    }
}
