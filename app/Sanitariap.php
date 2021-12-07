<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Sanitariap extends Model
{
    protected $table = 'sanitariasp';
    protected $primaryKey = 'id';

    protected $filliable = [
        'id',
        'nombre',
        'fechageneracion',
        'observaciones',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $guarded  = [
        
    ];

    public function campania(){
        return $this->belongsTo('App\Campania', 'idcampania', 'id');
    }

    public function tipo(){
        
    }
}
