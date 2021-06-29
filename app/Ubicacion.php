<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
    protected $table = 'ubicaciones';
    protected $primaryKey = 'idubicacion';

    protected $filliable = [
    	'idubicacion',
        'nombreubicacion',
        'expo',
        'impo',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
