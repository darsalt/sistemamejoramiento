<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Camara extends Model
{
    protected $table = 'camaras';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'estado',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
