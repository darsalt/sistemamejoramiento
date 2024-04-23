<?php

namespace App\Exports;

use App\Tacho;
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
        'Tacho',
        'Subtacho',
        'Clon',
        'Madre',
        'Padre',
        'Fecha Alta',
        'Observaciones',
        ];
    }

    public function collection()
    {
    	$tachos=DB::table('tachos as t')
        ->join('variedades as v', 'v.idvariedad', '=', 't.idvariedad')
     //   ->join('variedades as m', 'm.idvariedad', '=', 't.idvariedad')
     //   ->join('variedades as p', 'p.idvariedad', '=', 't.idvariedad')
        ->select('codigo','subcodigo','nombre','madre','padre','t.fechaalta','t.observaciones')
        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('codigo','desc')
        ->get();

        return $tachos;
    }
}
