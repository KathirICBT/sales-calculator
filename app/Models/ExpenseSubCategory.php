<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseSubCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category',
        'category_id',
        'report_order_number',
    ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'category_id');
    }
}
