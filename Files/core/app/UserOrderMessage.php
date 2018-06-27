<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrderMessage extends Model
{
    public function user() {
      return $this->belongsTo('App\User');
    }

    public function order() {
      return $this->belongsTo('App\Order');
    }

    public function deliveryRevision() {
      return $this->hasOne('App\DeliveryRevision');
    }

    public function deliveryAcceptance() {
      return $this->hasOne('App\DeliveryAcceptance');
    }
}
