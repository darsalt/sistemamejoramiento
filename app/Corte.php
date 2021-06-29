<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Corte extends Model
{
    protected $table = 'cortes';
    protected $primaryKey = 'idcorte';

    protected $filliable = [
    	'idcorte',
        'fechacorte',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
