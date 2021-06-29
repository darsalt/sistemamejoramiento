<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cruzamiento extends Model
{
    protected $table = 'cruzamientos';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'tipocruzamiento',
        'cruza',
        'cubiculo',
        'fechacruzamiento',
        'gramos',
        'conteo',
        'poder',
        'plantines',
        'stock'
    ];

    protected $guarded  = [
    	
    ];
}
