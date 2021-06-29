<?php

namespace App\Exports;

use App\Evaluacion;
use Maatwebsite\Excel\Concerns\FromCollection;

class EvaluacionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Exportacion::all();
    }
}
