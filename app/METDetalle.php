<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class METDetalle extends ClonalDetalleModel
{
    protected $table = 'met_detalle';
    public $timestamps = false;

    public function met(){
        return $this->belongsTo('App\MET', 'idmet', 'id');
    }

    public function parcelaSC(){
        return $this->belongsTo('App\SegundaClonalDetalle', 'idsegundaclonal_detalle', 'id');
    }

    public function evaluacionesCampoSanidad(){
        return $this->hasMany('App\EvaluacionDetalleCampoSanidadMET', 'idseedling', 'id');
    }

    public function evaluacionesLaboratorio(){
        return $this->hasMany('App\EvaluacionDetalleLaboratorioMET', 'idseedling', 'id');
    }
}
