<?php

namespace App\Exports;

use App\Importacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use DB;
class ImportacionesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
        'Variedad',
        'Tacho',
        'Ubicación',
        'Lote',
        'Fecha Ingreso',
        'Observaciones',
        ];
    }
    public function collection()
    {
    	$importaciones=DB::table('importaciones as e')
        ->select('v.nombre',DB::raw('CONCAT(codigo,"-",subcodigo)'),'nombreubicacion','nombrelote','fechaingreso','e.observaciones')
        ->join('variedades as v','v.idvariedad','=','e.idvariedad')
        ->join('tachos as t','t.idtacho','=','e.idtacho')
        ->join('ubicaciones as u','u.idubicacion','=','e.idubicacion')
        ->join('lotes as l','l.idlote','=','e.idlote')

        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('v.nombre','desc')
        ->get(); 

         return $importaciones;
     }

}
