<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    protected $primaryKey = 'idevaluacion';

    protected $filliable = [
    	'idevaluacion',
        'idexportacion',
        'idimportacion',
        'idtacho',
        'idvariedad',
        'idtipoevaluacion',
        'fechaevaluacion',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
