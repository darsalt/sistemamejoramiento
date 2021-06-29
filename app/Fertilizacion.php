<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Fertilizacion extends Model
{
    protected $table = 'fertilizaciones';
    protected $primaryKey = 'idfertilizacion';

    protected $filliable = [
    	'idfertilizacion',
        'fechafertilazacion',
        'producto',
        'cantidad',        
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}


