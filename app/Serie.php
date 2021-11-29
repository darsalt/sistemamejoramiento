<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'anio',
        'fechainicio',
        'fechafin',
        'comentarios',
        'vigente',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
