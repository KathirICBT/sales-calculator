<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherIncomeDepartment extends Model
{
    use HasFactory;
    protected $fillable = [
        'income_name',
        'category_id',
        'subcategory',
    ];

    public function incomeCategory()
    {
        return $this->belongsTo(IncomeCategory::class, 'category_id');
    }
}
