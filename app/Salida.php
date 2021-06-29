<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Salida extends Model
{
    protected $table = 'salidas';
    protected $primaryKey = 'idsalida';

    protected $filliable = [
    	'idsalida',
        'idexportacion',
        'pais',
        'programa',
        'fecharealizacion',
        'observaciones'
    ];

    protected $guarded  = [
    	
    ];
}
