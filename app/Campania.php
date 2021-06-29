<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Campania extends Model
{
    protected $table = 'campanias';
    protected $primaryKey = 'id';

    protected $fillable = [
    	'id',
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
