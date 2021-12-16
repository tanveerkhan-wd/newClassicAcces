<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function scopeFilter($query,array $data)
    {
        if ($data['search'] ?? false) {
            $query->where('name','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('mobile','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('address','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('bike_name','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('bike_model','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('bike_no','LIKE', '%'. $data['search'] . '%');
        }
    }
}
