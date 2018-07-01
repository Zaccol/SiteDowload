<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceImage extends Model
{
    public function service() {
      return $this->blongsTo('App\Service');
    }
}
