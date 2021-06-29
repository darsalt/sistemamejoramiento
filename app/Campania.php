<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Campania extends Model
{
    protected $table = 'campanias';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'nombre',
        'fechainicio',
        'fechafin',
        'comentarios',
        'vigente',
        'estado',
        'cruza',
        'cubiculo'
    ];

    protected $guarded  = [
    	
    ];
}
