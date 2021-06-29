<?php

namespace App\Imports;

use App\Registros;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Users;

class RegistrosImport implements ToModel, WithHeadingRow, WithCalculatedFormulas
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $fecha = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha']);
        $amanecer = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['amanecer']);
        $atardecer = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['atardecer']);
        $diferencia = $row['fotoperiodo'];
        
        $fotoperiodo = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($diferencia);

        return new Registros([
            'idtratamiento' => Auth()->user()->id,
            'fecha'         => $fecha,
            'amanecer'      => $amanecer,
            'atardecer'     => $atardecer,
            'Fotoperiodo'   => $fotoperiodo,
        ]);
    }
}
