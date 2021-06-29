<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    protected $table = 'ambientes';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'comentarios',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $guarded  = [
    	
    ];
}
