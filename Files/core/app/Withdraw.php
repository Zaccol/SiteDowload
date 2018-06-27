<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Withdraw extends Model
{
    public function user() {
      return $this->belongsTo('App\User');
    }

    public function withdrawMethod() {
      return $this->belongsto('App\WithdrawMethod');
    }
}
