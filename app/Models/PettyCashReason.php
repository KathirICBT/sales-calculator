<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PettyCashReason extends Model
{
    use HasFactory;

    protected $fillable = [
        'reason',
        'expense_category_id',
        'expense_sub_category_id',
        'supplier',
        'purchase_type',
    ];

    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }

    public function expenseSubCategory()
    {
        return $this->belongsTo(ExpenseSubCategory::class, 'expense_sub_category_id');
    }
    
}
