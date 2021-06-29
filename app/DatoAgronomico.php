<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class DatoAgronomico extends Model
{
    protected $table = 'datosagronomicos';
    protected $primaryKey = 'id';

    protected $filliable = [
        'id',
        'idbanco',
        'idubicacion',
        'tallos',
        'altura',
        'grosor',
        'vuelco',
        'floracion',
        'otra'
    ];

    protected $guarded  = [
        
    ];
}
