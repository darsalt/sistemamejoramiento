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
        'Box',
        'Tacho',
        'Fecha Ingreso',
        'Observaciones',
        'Estado'
        ];
    }
    public function collection()
    {
    	$exportaciones=DB::table('exportaciones as e')
        ->select('b.nombre',DB::raw('CONCAT(codigo,"-",subcodigo)'),'e.fechaingreso','e.observaciones', 'e.estado')
        ->join('tachos as t','t.idtacho','=','e.idtacho')
        ->join('boxesexpo as b', 'b.id', '=', 'e.idbox')
        ->get(); 

         return $exportaciones;
     }

}
