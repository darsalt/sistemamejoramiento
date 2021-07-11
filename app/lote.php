<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    protected $table = 'lotes';
    protected $primaryKey = 'idlote';

    protected $filliable = [
    	'idlote',
        'nombrelote'
    ];

    protected $guarded  = [
    	
    ];

    public function subambiente(){
        return $this->belongsTo('App\Subambiente', 'idsubambiente', 'id');
    }
}
