<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seedling extends Model
{
    public function campania(){
        return $this->belongsTo('App\CampaniaSeedling', 'idcampania', 'id');
    }

    public function semillado(){
        return $this->belongsTo('App\Semillado', 'idsemillado', 'idsemillado');
    }

    public function lote(){
        return $this->belongsTo('App\Lote', 'idlote', 'idlote');
    }
}
