<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sound extends Model
{
    //
    protected $fillable = [
        'node_id', 'sound_value',
        ];
}
