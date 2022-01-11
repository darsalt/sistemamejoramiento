<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Importacion extends Model
{
    protected $table = 'importaciones';
    protected $primaryKey = 'idimportacion';

    protected $filliable = [
    	'idimportacion',
        'idvariedad',
        'idtacho',
        'idubicacion',
        'idlote',
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
        return $this->belongsTo('App\BoxImportacion', 'idbox', 'id');
    }

    public function campania(){
        return $this->belongTo('App\CampaniaCuarentena', 'idcampania', 'id');
    }
}
