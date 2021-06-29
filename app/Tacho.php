<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tacho extends Model
{
    protected $table = 'tachos';
    protected $primaryKey = 'idtacho';

    protected $filliable = [
    	'idtacho',
        'codigo',
        'subcodigo',
        'fechaalta',
        'idvariedad',
        'destino',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
