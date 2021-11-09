<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionDetalleCampoSanidadPC extends Model
{
    public $timestamps = false;
    protected $table = 'evaluacionesdetalle_camposanidad_pc';

    public function evaluacion(){
        return $this->belongsTo('App\EvaluacionPrimeraClonal', 'idevaluacion', 'id');
    }
}
