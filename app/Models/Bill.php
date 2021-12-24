<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    
    public function scopeFilter($query,array $data)
    {
        $customer = $data['customer_id'] ?? '';
        $query->where('customer_id',$customer);
        $search = $data['search'];
        if ($search ?? false) {
            $query->where( function ($query) use($search)
            {
                $query->where('id','LIKE', '%'. $search . '%')
                    ->orWhere('km_head','LIKE', '%'. $search . '%')
                    ->orWhere('service_amt','LIKE', '%'. $search . '%')
                    ->orWhere('discount','LIKE', '%'. $search . '%')
                    ->orWhere('total_amt','LIKE', '%'. $search . '%')
                    ->orWhere('notes','LIKE', '%'. $search . '%');
            });
        }
        if ($data['payment_status'] ?? false) {
            $query->where('payment_status',$data['payment_status']);
        }
    }

    public function scopefilterBills($query,array $data)
    {
        $search = $data['search'];
        if ($search ?? false) {
            $query->where( function ($query) use($search)
            {
                $query->where('id','LIKE', '%'. $search . '%')
                    ->orWhere('km_head','LIKE', '%'. $search . '%')
                    ->orWhere('service_amt','LIKE', '%'. $search . '%')
                    ->orWhere('discount','LIKE', '%'. $search . '%')
                    ->orWhere('total_amt','LIKE', '%'. $search . '%')
                    ->orWhere('notes','LIKE', '%'. $search . '%');
            });

            $query->whereHas('customer',function ($query) use($search)
            {
                $query->where('name','LIKE', '%'. $search .'%');
            });
        }
        if ($data['payment_status'] ?? false) {
            $query->where('payment_status',$data['payment_status']);
        }

    }


    public function products()
    {
        return $this->hasMany(BillProduct::class,'bill_id')->with('product');
    }
    
    public function accessories()
    {
        return $this->hasMany(BillAccessory::class,'bill_id')->with('accessory');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class,'id','customer_id');
    }

}
