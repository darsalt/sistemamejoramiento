<?php

namespace App\Exports;

use App\Banco;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use DB;


class BancosExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
        'nombre',
        'fechageneracion',
        'tablas',
        'tablitas',
        'surcos',
        'parcelas',
        'observaciones',
        ];
    }

    public function collection()
    {
    	$bancos=DB::table('bancos as v')
        ->select('nombre','fechageneracion', 'tablas','tablitas','surcos','parcelas','observaciones',)
        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('nombre','desc')
        ->get();

        return $bancos;
    }
}
