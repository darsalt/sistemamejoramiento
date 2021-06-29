<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'comentarios',
        'idsubambiente',
        'created_at',
        'updated_at'
    ];

    protected $guarded  = [
    	
    ];
}
