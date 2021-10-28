<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class METDetalle extends Model
{
    protected $table = 'met_detalle';
    public $timestamps = false;

    public function met(){
        return $this->belongsTo('App\MET', 'idmet', 'id');
    }

    public function parcelaSC(){
        return $this->belongsTo('App\SegundaClonalDetalle', 'idsegundaclonal_detalle', 'id');
    }

    public function variedad(){
        return $this->belongsTo('App\Variedad', 'idvariedad', 'idvariedad');
    }
}
