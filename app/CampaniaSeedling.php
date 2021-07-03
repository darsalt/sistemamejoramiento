<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaniaSeedling extends Model
{
    protected $table = 'campaniaseedling';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'fechainicio',
        'fechafin',
        'comentarios',
        'vigente',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
