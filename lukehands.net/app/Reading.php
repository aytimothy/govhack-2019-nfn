<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reading extends Model
{
    //
    protected $fillable = [
        'node_id', 'time','temperature', 'humidity', 'sound', 'light',
    ];
}
