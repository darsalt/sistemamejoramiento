<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

abstract class ClonalDetalleModel extends Model
{
    abstract public function evaluacionesCampoSanidad();

    abstract public function evaluacionesLaboratorio();

    public function sector(){
        return $this->belongsTo('App\Sector', 'idsector', 'id');
    }

    public function variedad(){
        return $this->belongsTo('App\Variedad', 'idvariedad', 'idvariedad');
    }

    public function getEvaluacionCampoSanidadAttribute($evaluacion, $attribute, $digitsFormat = 0){
        $ev = $this->evaluacionesCampoSanidad()->where('idevaluacion', $evaluacion->id)->first();
        return $ev ? (!is_null($ev->$attribute) ? number_format($ev->$attribute, $digitsFormat) : '') : '';
    }

    public function getEvaluacionLaboratorioAttribute($evaluacion, $attribute, $digitsFormat = 0){
        $ev = $this->evaluacionesLaboratorio()->where('idevaluacion', $evaluacion->id)->first();
        return $ev ? (!is_null($ev->$attribute) ? number_format($ev->$attribute, $digitsFormat) : '') : '';
    }

    public function isReadonly($evaluacion, $user)
    {
        return $user->idambiente != $evaluacion->sector->subambiente->ambiente->id && $user->esAdmin != 1;
    }
}
