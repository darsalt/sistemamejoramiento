<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDetalleLaboratorioPC extends Model
{
    public $timestamps = false;
    protected $table = 'evaluacionesdetalle_laboratorio_pc';

    public function evaluacion(){
        return $this->belongsTo('App\EvaluacionPrimeraClonal', 'idevaluacion', 'id');
    }
}
