<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherExpense extends Model
{
    use HasFactory;

    protected $fillable = [
        'shop_id',
        'date',
        'expense_reason_id',
        'paymenttype_id', 
        'amount',
    ];

    // Define the relationship with Shop model
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    // Define the relationship with PettyCashReason model
    public function expenseReason()
    {
        return $this->belongsTo(PettyCashReason::class, 'expense_reason_id');
    }

    // Define the relationship with PaymentType model
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymenttype_id');
    }

}
