<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryAcceptance extends Model
{
    public function UserOrderMessage() {
      return $this->belongsTo('App\UserOrderMessage');
    }
}
