<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WithdrawMethod extends Model
{
    protected $fillable = ['name', 'min_limit', 'max_limit', 'fixed_charge', 'percentage_charge', 'process_time'];

    public function withdraws() {
      return $this->hasMany('App\Withdraw');
    }
}
