<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    //
    protected $table = 'nodes';
    protected $fillable = [

    ];
    public function getReads(){
        return $this->hasMany('App\Reading', 'node_id', 'id');
    }
}
