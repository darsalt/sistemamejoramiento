<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDetalleCampoSanidadSC extends Model
{
    public $timestamps = false;
    protected $table = 'evaluacionesdetalle_camposanidad_sc';

    public function evaluacion(){
        return $this->belongsTo('App\EvaluacionSegundaClonal', 'idevaluacion', 'id');
    }
}
