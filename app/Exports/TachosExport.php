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
        'Fecha Alta',
        'Observaciones',
        ];
    }

    public function collection()
    {
    	$tachos=DB::table('tachos as t')
        ->select('codigo','subcodigo','fechaalta','observaciones')
        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('codigo','desc')
        ->get();

        return $tachos;
    }
}
