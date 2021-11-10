<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDetalleLaboratorioMET extends Model
{
    public $timestamps = false;
    protected $table = 'evaluacionesdetalle_laboratorio_met';

    public function evaluacion(){
        return $this->belongsTo('App\EvaluacionMET', 'idevaluacion', 'id');
    }
}
