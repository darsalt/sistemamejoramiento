<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDetalleLaboratorioSC extends Model
{
    public $timestamps = false;
    protected $table = 'evaluacionesdetalle_laboratorio_sc';

    public function evaluacion(){
        return $this->belongsTo('App\EvaluacionSegundaClonal', 'idevaluacion', 'id');
    }
}
