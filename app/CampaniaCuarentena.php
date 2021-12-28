<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class CampaniaCuarentena extends Model
{
    protected $table = 'campaniacuarentena';
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
