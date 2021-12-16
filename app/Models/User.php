<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
	use Notifiable;
    protected $primaryKey = "user_id";
  	protected $fillable = [
        'name', 'email', 'password','fb_id','google_id',
    ];
}
