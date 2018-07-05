<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Macs extends Model
{
    protected $fillable = [
        'macid', 'status',
    ];
}
