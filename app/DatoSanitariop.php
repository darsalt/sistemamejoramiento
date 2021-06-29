<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoSanitariop extends Model
{
    protected $table = 'datossanitariosp';
    protected $primaryKey = 'id';

    protected $filliable = [
        'id',
        'idtacho',
        'idevaluacion',
        'carbon',
        'escaladura',
        'estriaroja',
        'mosaico',
        'royamarron',
        'royaanaranjada',
        'pokkaboeng',
        'amarillamiento',
        'manchaparda',                                
        'otra'
    ];

    protected $guarded  = [
        
    ];
}
