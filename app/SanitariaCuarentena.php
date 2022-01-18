<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SanitariaCuarentena extends Model
{
    protected $table = 'sanitarias_cuarentena';

    public function campania(){
        return $this->belongsTo('App\CampaniaCuarentena', 'idcampania', 'id');
    }
}
