<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnvioExportacion extends Model
{
    public $timestamps = false;
    protected $table = 'exportaciones_envios';

    public function box(){
        return $this->belongsTo('App\BoxExportacion', 'idbox', 'id');
    }

    public function tacho(){
        return $this->belongsTo('App\Tacho', 'idtacho', 'idtacho');
    }
}
