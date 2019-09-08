<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Light extends Model
{
    //
    protected $fillable = [
        'node_id', 'lux_value',
    ];
}
