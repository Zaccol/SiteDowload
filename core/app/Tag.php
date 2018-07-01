<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function service() {
      return $this->belongsTo('App\Service');
    }
}
