<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'idproveedor';
    public $timestamps = false;

    protected $filliable = [
    	'Codigo',
        'TipoIdentificacion',
        'CUIT',
        'RazonSocial',
        'Domicilio',
        'Localidad',
        'CodigoPostal',
        'Telefono',
        'CorreoElectronico',
        'LiquidaIVA',
    	'activo'
    ];

    protected $guarded  = [
    	
    ];
}
