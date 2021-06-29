<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Importacion extends Model
{
    protected $table = 'importaciones';
    protected $primaryKey = 'idimportacion';

    protected $filliable = [
    	'idimportacion',
        'idvariedad',
        'idtacho',
        'idubicacion',
        'idlote',
        'fechaingreso',
        'fechaegreso',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
