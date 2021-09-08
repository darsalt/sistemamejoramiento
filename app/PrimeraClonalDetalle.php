<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrimeraClonalDetalle extends Model
{
    protected $table = 'primerasclonal_detalle';
    public $timestamps = false;

    public function primera(){
        return $this->belongsTo('App\PrimeraClonal', 'idprimeraclonal', 'id');
    }

    public function segunda(){
        return $this->hasOne('App\SegundaClonalDetalle', 'idprimeraclonal_detalle', 'id');
    }
}
