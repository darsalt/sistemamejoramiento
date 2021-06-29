<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarea extends Model
{
    protected $table = 'tareas';
    protected $primaryKey = 'idtarea';

    protected $filliable = [
    	'idtarea',
        'idvariedad',
        'idtacho', 
        'idexportacion',
        'idimportacion',
        'idtipotarea',
        'fecharealizacion',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
