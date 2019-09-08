<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    protected $fillable = [
        'node_id', 'latitude','northsouth','longitude','eastwest','date','gps_utc_time','altitude','speed','course'
    ];
}
