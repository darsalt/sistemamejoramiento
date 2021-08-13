<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PrimeraClonal extends Model
{
    protected $table = 'primerasclonal';

    public function seedling(){
        return $this->belongsTo('App\Seedling', 'idseedling', 'id');
    }

    public function serie(){
        return $this->belongsTo('App\Serie', 'idserie', 'id');
    }

    public function sector(){
        return $this->belongsTo('App\Sector', 'idsector', 'id');
    }

    public function parcelas(){
        return $this->hasMany('App\PrimeraClonalDetalle', 'idprimeraclonal', 'id');
    }
}
