<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoSanitario extends Model
{
    protected $table = 'datossanitarios';
    protected $primaryKey = 'id';

    protected $filliable = [
        'id',
        'idbanco',
        'idubicacion',
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
