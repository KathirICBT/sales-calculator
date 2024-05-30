<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillImage extends Model
{
    use HasFactory;
    protected $fillable = ['staff_id', 'shop_id', 'image','date'];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
