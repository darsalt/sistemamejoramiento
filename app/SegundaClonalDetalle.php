<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SegundaClonalDetalle extends Model
{
    protected $table = 'segundasclonal_detalle';
    public $timestamps = false;

    public function parcelaPC(){
        return $this->belongsTo('App\PrimeraClonalDetalle', 'idprimeraclonal_detalle', 'id');
    }

    public function segunda(){
        return $this->belongsTo('App\SegundaClonal', 'idsegundaclonal', 'id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'idsector', 'id');
    }
}
