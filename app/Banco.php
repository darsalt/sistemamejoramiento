<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Banco extends Model
{
    protected $table = 'bancos';
    protected $primaryKey = 'idbanco';

    protected $filliable = [
    	'idbanco',
        'nombre',
        'anio',
        'fechageneracion',
        'tablas',
        'tablitas',
        'surcos',
        'parcelas',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
