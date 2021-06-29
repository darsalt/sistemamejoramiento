<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sanitaria extends Model
{
    protected $table = 'sanitarias';
    protected $primaryKey = 'id';

    protected $filliable = [
        'id',
        'idbanco',
        'nombre',
        'fechageneracion',
        'observaciones',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $guarded  = [
        
    ];
}
