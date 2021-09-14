<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MET extends Model
{
    protected $table = 'met';

    public function parcelas(){
        return $this->hasMany('App\METDetalle', 'idmet', 'id');
    }
}
