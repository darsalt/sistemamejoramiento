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

    public function campaniasemillado(){
        return $this->belongsTo('App\CampaniaSemillado', 'idcampaniasemillado', 'id');
    }

    public function campaniacruzamiento(){
        return $this->belongsTo('App\CampaniaCruzamiento', 'idcampaniacruzamiento', 'id');
    }
}
