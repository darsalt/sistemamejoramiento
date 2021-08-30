<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SegundaClonal extends Model
{
    protected $table = 'segundasclonal';

    public function parcelas(){
        return $this->hasMany('App\PrimeraClonalDetalle', 'idsegundaclonal', 'id');
    }

    public function serie(){
        return $this->belongsTo('App\Serie', 'idserie', 'id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'idsector', 'id');
    }
}
