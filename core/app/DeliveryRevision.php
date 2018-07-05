<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryRevision extends Model
{
    public function userOrderMessage() {
      return $this->belongsTo('App\UserOrderMessage');
    }
}
