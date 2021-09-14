<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class METDetalle extends Model
{
    protected $table = 'met_detalle';
    public $timestamps = false;

    public function met(){
        return $this->belongsTo('App\MET', 'idmet', 'id');
    }
}
