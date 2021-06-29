<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TalloCruzamiento extends Model
{
    protected $table = 'tallocruzamientos';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'idtallo',
        'idtallomadre',
        'idcruzamiento'
    ];

    protected $guarded  = [
    	
    ];
}
