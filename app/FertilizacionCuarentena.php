<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FertilizacionCuarentena extends Model
{
    protected $table = 'fertilizaciones_cuarentena';

    public function campania(){
        return $this->belongsTo('App\CampaniaCuarentena', 'idcampania', 'id');
    }

    public function boximpo(){
        return $this->belongsTo('App\BoxImportacion', 'idboximpo', 'id');
    }

    public function boxexpo(){
        return $this->belongsTo('App\BoxExportacion', 'idboxexpo', 'id');
    }
}
