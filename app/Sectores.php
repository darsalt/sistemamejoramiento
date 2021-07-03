<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectores extends Model
{
    protected $table = 'sectores';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'idsubambiente',
        'comentarios',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $guarded  = [
    	
    ];
}
