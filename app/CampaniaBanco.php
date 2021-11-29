<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaniaBanco extends Model
{
    protected $table = 'campaniabanco';
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
