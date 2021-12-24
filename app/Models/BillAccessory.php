<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillAccessory extends Model
{
    protected $fillable = [];

    public function accessory()
    {
        return $this->hasOne(Accessories::class,'id','accessory_id');
    }
}
