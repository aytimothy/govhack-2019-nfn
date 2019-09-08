<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Humidity extends Model
{
    //
    protected $fillable = [
        'node_id', 'humidity',
    ];
}
