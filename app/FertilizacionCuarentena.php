<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FertilizacionCuarentena extends Model
{
    protected $table = 'fertilizaciones_cuarentena';

    public function campania(){
        return $this->belongsTo('App\CampaniaCuarentena', 'idcampania', 'id');
    }
}
