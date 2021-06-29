<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Exportacion extends Model
{
    protected $table = 'exportaciones';
    protected $primaryKey = 'idexportacion';

    protected $filliable = [
    	'idexportacion',
        'idvariedad',
        'idtacho',
        'idubicacion',
        'fechaingreso',
        'fechaegreso',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
