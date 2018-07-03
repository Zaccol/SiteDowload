<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'firstname', 'lastname', 'password', 'ref_username', 'email_verified', 'sms_verified', 'email_ver_code', 'sms_ver_code', 'country', 'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts() {
      return $this->hasMany('App\Post');
    }

    public function comments() {
      return $this->hasMany('App\Comment');
    }

    public function services() {
      return $this->hasMany('App\Service');
    }

    public function userOrderMessages() {
      return $this->hasMany('App\UserOrderMessage');
    }

    public function withdraws() {
      return $this->hasMany('App\Withdraw');
    }

    public function deposits() {
      return $this->hasMany('App\Deposit');
    }
}
