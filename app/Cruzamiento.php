<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cruzamiento extends Model
{
    protected $table = 'cruzamientos';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'tipocruzamiento',
        'cruza',
        'cubiculo',
        'fechacruzamiento',
        'gramos',
        'conteo',
        'poder',
        'plantines',
        'stock'
    ];

    protected $guarded  = [
    	
    ];

    public function madre(){
        return $this->belongsTo('App\Variedad', 'idmadre', 'idvariedad');
    }

    public function padre(){
        return $this->belongsTo('App\Variedad', 'idpadre', 'idvariedad');
    }

    public function semilla(){
        return $this->hasOne('App\Semilla', 'idcruzamiento', 'id');
    }

    public function campaniaCruzamiento(){
        return $this->belongsTo('App\Campania', 'idcampania', 'id');
    }
}
