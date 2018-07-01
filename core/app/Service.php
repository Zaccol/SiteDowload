<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public function category() {
      return $this->belongsTo('App\Category');
    }

    public function tags() {
      return $this->hasMany('App\Tag');
    }

    public function serviceImages() {
      return $this->hasMany('App\ServiceImage');
    }

    public function user() {
      return $this->belongsTo('App\User');
    }

    public function orders() {
      return $this->hasMany('App\Order');
    }
}
