<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Semilla extends Model
{
    protected $table = 'semillas';
    protected $primaryKey = 'idsemilla';
    public $timestamps = false;

    protected $filliable = [
    	'idsemilla',
        'idcruzamiento',
        'stockinicial',
        'stockactual',
        'madre',
        'padre',
        'fechaingreso',
        'procedencia',
        'podergerminativo',
        'observaciones'
    ];

    protected $guarded  = [
    	
    ];
}
