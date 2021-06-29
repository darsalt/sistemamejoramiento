<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tratamiento extends Model
{
    protected $table = 'tratamientos';
    protected $primaryKey = 'idtratamiento';

    protected $filliable = [
    	'idtratamiento',
        'nombre',
        'descripción',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
