<?php

namespace App\Exports;

use App\Variedad;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use DB;


class VariedadesExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return [
        'nombre',
        'madre',
        'padre',
        'fechaalta',
        'tonelaje',
        'azucar',
        'floracion',
        'resistencia',
        'suelos',
        'fibra',
        'observaciones',
        ];
    }

    public function collection()
    {
    	$variedades=DB::table('variedades as v')
        ->select('nombre','madre','padre','fechaalta', 'tonelaje','azucar','floracion','resistencia','suelos','fibra','observaciones',)
        //->where ('nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    	->orderBy('nombre','desc')
        ->get();

        return $variedades;
    }
}
