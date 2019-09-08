<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Turbidity extends Model
{
    //
    protected $fillable = [
        'node_id','pwm_value', 'analog_read', 'ntu',
    ];
}
