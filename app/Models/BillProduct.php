<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillProduct extends Model
{
    protected $fillable = [];

    public function product()
    {
        return $this->hasOne(Product::class,'id','product_id');
    }
}
