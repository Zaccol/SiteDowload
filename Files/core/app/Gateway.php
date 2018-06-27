<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $table = 'gateways';

    public function deposits() {
      return $this->hasMany('App\Deposit');
    }
}
