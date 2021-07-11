<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Subambiente extends Model
{
    protected $table = 'subambientes';
    protected $primaryKey = 'id';

    protected $filliable = [
    	'id',
        'nombre',
        'idambiente',
        'comentarios',
        'estado',
        'created_at',
        'updated_at'
    ];

    protected $guarded  = [
    	
    ];

    public function ambiente(){
        return $this->belongsTo('App\Ambiente', 'idambiente', 'id');
    }
}
