<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Exportacion extends Model
{
    protected $table = 'exportaciones';
    protected $primaryKey = 'idexportacion';

    protected $filliable = [
    	'idexportacion',
        'idvariedad',
        'idtacho',
        'idubicacion',
        'fechaingreso',
        'fechaegreso',
        'observaciones',
        'estado'
    ];

    protected $guarded  = [
    	
    ];

    public function tacho(){
        return $this->belongsTo('App\Tacho', 'idtacho', 'idtacho');
    }

    public function box(){
        return $this->belongsTo('App\BoxExportacion', 'idbox', 'id');
    }

    public function campania(){
        return $this->belongTo('App\CampaniaCuarentena', 'idcampania', 'id');
    }
}
