<?php

namespace App\Exports;

use App\Exportacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use DB;
class ExportacionesExport implements FromCollection, WithHeadings, ShouldAutoSize
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
        'Fecha Ingreso',
        'Observaciones',
        ];
    }
    public function collection()
    {
    	$exportaciones=DB::table('exportaciones as e')
        ->select('v.nombre',DB::raw('CONCAT(codigo,"-",subcodigo)'),'nombreubicacion','fechaingreso','e.observaciones')
        ->join('variedades as v','v.idvariedad','=','v.idvariedad')
        ->join('tachos as t','t.idtacho','=','e.idtacho')
        ->join('ubicaciones as u','u.idubicacion','=','e.idubicacion')

        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('v.nombre','desc')
        ->get(); 

         return $exportaciones;
     }

}
