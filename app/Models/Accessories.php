<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accessories extends Model
{
    public function scopeFilter($query,array $data)
    {
        if ($data['search'] ?? false) {
            $query->where('firm_name','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('part_no','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('part_name','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('rate','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('quantity','LIKE', '%'. $data['search'] . '%')
                  ->orWhere('price','LIKE', '%'. $data['search'] . '%');
        }
    }
}
