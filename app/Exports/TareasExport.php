<?php

namespace App\Exports;

use App\Tarea;
use Maatwebsite\Excel\Concerns\FromCollection;

class TareaExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Exportacion::all();
    }
}
