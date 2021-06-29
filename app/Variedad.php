<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Variedad extends Model
{
    protected $table = 'variedades';
    protected $primaryKey = 'idvariedad';

    protected $fillable = [
    	'idvariedad',
        'nombre',
        'madre',
        'padre',
        'fechaalta',
        'idtacho',
        'tonelage',
        'azucar',
        'floracion',
        //'resistencia',
        'suelos',
        'fibra',
        'deshojado',
        'carbon',
        'escaladura',
        'estriaroja',
        'mosaico',
        'royamarron',
        'royanaranja',
        'pokkaboeng',
        'amarillamiento',
        'manchaparda',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];
}
