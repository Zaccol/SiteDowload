<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function service() {
      return $this->belongsTo('App\Service');
    }

    public function userOrderMessages() {
      return $this->hasMany('App\UserOrderMessage');
    }
}
