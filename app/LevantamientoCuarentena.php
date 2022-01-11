<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LevantamientoCuarentena extends Model
{
    protected $table = 'levantamientos_cuarentena';

    public function campania(){
        return $this->belongsTo('App\CampaniaCuarentena', 'idcampania', 'id');
    }

    public function box(){
        return $this->belongsTo('App\BoxImportacion', 'idbox', 'id');
    }
}
