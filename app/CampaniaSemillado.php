<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaniaSemillado extends Model
{
    protected $table = 'campaniasemillado';
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
