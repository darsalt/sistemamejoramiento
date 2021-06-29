<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tallo extends Model
{
    protected $table = 'tallos';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'numero',
        'fechafloracion',
        'idtacho',
        'polen',
        'enmasculado',
    ];

    protected $guarded  = [
    	
    ];
}
