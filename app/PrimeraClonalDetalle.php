<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrimeraClonalDetalle extends ClonalDetalleModel
{
    protected $table = 'primerasclonal_detalle';
    public $timestamps = false;

    public function primera(){
        return $this->belongsTo('App\PrimeraClonal', 'idprimeraclonal', 'id');
    }

    public function segundas(){
        return $this->hasMany('App\SegundaClonalDetalle', 'idprimeraclonal_detalle', 'id');
    }

    public function evaluacionesCampoSanidad(){
        return $this->hasMany('App\EvaluacionDetalleCampoSanidadPC', 'idseedling', 'id');
    }

    public function evaluacionesLaboratorio(){
        return $this->hasMany('App\EvaluacionDetalleLaboratorioPC', 'idseedling', 'id');
    }
}
