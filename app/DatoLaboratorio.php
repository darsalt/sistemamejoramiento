<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoLaboratorio extends Model
{
    protected $table = 'datoslaboratorios';
    protected $primaryKey = 'id';

    protected $filliable = [
        'id',
        'idbanco',
        'idubicacion',
        'pesomuestra',
        'pesojugo',
        'brix',
        'polarizacion',
        'temperatura',
        'conductividad',
        'brixcorregido',
        'polenjugo',
        'pureza',
        'rendimientoprobable',
        'polencana',                                
        'otra'
    ];

    protected $guarded  = [
        
    ];
}
