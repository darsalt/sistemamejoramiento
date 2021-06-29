<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Agronomica extends Model
{
    protected $table = 'agronomicas';
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
