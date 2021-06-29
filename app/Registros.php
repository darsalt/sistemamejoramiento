<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Registros extends Model
{
    protected $table = 'registrostratamiento';
    protected $primaryKey = 'idregistro';

    protected $filliable = [
    	'idregistro',
        'idtratamiento',
        'fecha',
        'amanecer',
        'atardecer',
        'Fotoperiodo'
    ];

    protected $guarded  = [
    	
    ];
}
