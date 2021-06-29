<?php

namespace App\Imports;

use App\Cruzamiento;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use App\Variedad;
use App\Tacho;
use DB;


class CruzamientosImport implements ToModel , WithHeadingRow, WithValidation
{
    private $numRows = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        ++$this->numRows;

        $padreId = Variedad::where('nombre', 'LIKE', '%'.$row['variedad1c12'].'%')->value('idvariedad');
        $madreId = Variedad::where('nombre', 'LIKE', '%'.$row['variedad2c12'].'%')->value('idvariedad');
        $tachoPadre = Tacho::where('idvariedad', '=', $padreId)->first();
        $tachoMadre = Tacho::where('idvariedad', '=', $madreId)->first();
        
        if (!$tachoPadre) {
            $tachoPadre = new Tacho([
                'idvariedad' => $padreId,
                'codigo' => rand(1000,10000),
                'subcodigo' => 'A',
                'fechaalta' => '2021-01-01',
                'estado' => 'Baja',
            ]);
            $tachoPadre->save();
        }
        if (!$tachoMadre) {
            $tachoMadre = new Tacho([
                'idvariedad' => $madreId,
                'codigo' => rand(1000,10000),
                'subcodigo' => 'A',
                'fechaalta' => '2021-01-01',
                'estado' => 'Baja',
            ]);
            $tachoMadre->save();
        }

        return new Cruzamiento([
            'tipocruzamiento' => 'Biparental',
            'cruza' => $row['cruzan100'],
            'cubiculo' => $row['cubiculon50'],
            'fechacruzamiento' => '2020-10-10',
            'idpadre' => $tachoPadre->idtacho,
            'idmadre' => $tachoMadre->idtacho,
            'gramos' => $row['gramosn101'],
            // 'conteo' => $row['conteo'],
            'poder' => $row['podern100'],
            // 'plantines' => $row['plantines'],
            'estado' => 1,
        ]);
    }

    public function rules(): array
    {
        return [
            // 'tipocruzamiento' => 'required|max:45',
            // 'cruza' => 'required',
            // 'cubiculo' => 'required',
            // 'fechacruzamiento' => 'required',
            // 'gramos' => 'required',
            // 'conteo' => 'required',
            // 'poder' => 'required',
            // 'plantines' => 'required',
        ];
    }
 
    public function getRowCount(): int
    {
        return $this->numRows;
    }
}
