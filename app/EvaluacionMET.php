<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EvaluacionMET extends Model
{
    public $timestamps = false;
    protected $table = 'evaluaciones_met';

    public function serie(){
        return $this->belongsTo('App\Serie', 'idserie', 'id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'idsector', 'id');
    }

    public function edad(){
        return $this->belongsTo('App\Edad', 'idedad', 'id');    
    }
}
