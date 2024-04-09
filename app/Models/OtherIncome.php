<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherIncome extends Model
{
    use HasFactory;
    protected $fillable = [
        'other_income_department_id',
        'paymenttype_id',
        'amount',
        'shop_id', 
        'date',
    ];

    public function otherIncomeDepartment()
    {
        return $this->belongsTo(OtherIncomeDepartment::class, 'other_income_department_id');
    }

    public function paymentType()
    {
        return $this->belongsTo(PaymentType::class, 'paymenttype_id');
    }
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}
