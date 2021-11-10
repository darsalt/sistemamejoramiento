<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDetalleCampoSanidadMET extends Model
{
    public $timestamps = false;
    protected $table = 'evaluacionesdetalle_camposanidad_met';

    public function evaluacion(){
        return $this->belongsTo('App\EvaluacionMET', 'idevaluacion', 'id');
    }
}
