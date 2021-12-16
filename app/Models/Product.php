<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function scopeFilter($query,array $data)
    {
        if ($data['search'] ?? false) {
            $query->where('name','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('code','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('quantity','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('price','LIKE', '%'. $data['search'] . '%');
        }
    }
}
