<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class VariedadesBanco extends Model
{
    protected $table = 'variedadesbanco';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $filliable = [
    	'id',
        'idbanco',
        'tabla',
        'tablita',
        'surco',
        'parcela',
        'idvariedad',
        'testigo',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
