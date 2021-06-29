<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Laboratorio extends Model
{
    protected $table = 'laboratorios';
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
