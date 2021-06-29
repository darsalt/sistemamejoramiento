<?php

namespace App\Exports;

use App\Ubicacion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use DB;
class TachosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
        'Ubicacion',
        'Variedad',
        'Tacho',
        'Subtacho',
        'Fecha Alta',
        'Observaciones',
        ];
    }

    public function collection()
    {
    	$ubicaciones=DB::table('ubicaciones as u')
        ->select('nombreubicacion','nombrevariedad','codigo','subcodigo','fechaalta','observaciones')
        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('idubicacion','desc')
        ->get();

        return $ubicaciones;
    }
}
