<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    
    public function scopeFilter($query,array $data)
    {
        $customer = $data['customer_id'] ?? '';
        $query->where('customer_id',$customer);

        if ($data['search'] ?? false) {
            $query->where('bill_no','LIKE', '%'. $data['search'] . '%');
        }
    }

    public function products()
    {
        return $this->hasMany(BillProduct::class,'bill_id')->with('product');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }

}
