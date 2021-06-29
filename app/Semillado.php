<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semillado extends Model
{
    protected $primaryKey = 'idsemillado';
    public $timestamps = false;

    public function cruzamiento(){
        return $this->belongsTo('App\Cruzamiento', 'idcruzamiento', 'id');
    }

    public function campania(){
        return $this->belongsTo('App\CampaniaSemillado', 'idcampania', 'id');
    }
}
