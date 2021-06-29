<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    protected $table = 'inspecciones';
    protected $primaryKey = 'idinspeccion';

    protected $filliable = [
    	'idinspeccion',
        'fechainspeccion',
        'certificado',
        'observaciones'
    ];

    protected $guarded  = [
    	
    ];
}
