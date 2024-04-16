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

    
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    
    public function expenseReason()
    {
        return $this->belongsTo(PettyCashReason::class, 'expense_reason_id');
    }

    
    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymenttype_id');
    }

}
