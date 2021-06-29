<?php

namespace App\Exports;

use App\Ambientes;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use DB;


class AmbientesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
        'nombre',
        'comentarios',
        ];
    }

    public function collection()
    {
    	$ambientes=DB::table('ambientes as v')
        ->select('nombre','comentarios',)
        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('nombre','desc')
        ->get();

        return $ambientes;
    }
}
