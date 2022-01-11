<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Inspeccion extends Model
{
    protected $table = 'inspecciones';
    protected $primaryKey = 'idinspeccion';

    protected $filliable = [
        'fechainspeccion',
        'certificado',
        'observaciones'
    ];

    protected $guarded  = [
    	
    ];

    public function campania(){
        return $this->belongsTo('App\CampaniaCuarentena', 'idcampania', 'id');
    }

    public function box(){
        return $this->belongsTo('App\BoxImportacion', 'idbox', 'id');
    }
}
