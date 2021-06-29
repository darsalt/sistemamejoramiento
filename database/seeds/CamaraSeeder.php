<?php

use Illuminate\Database\Seeder;

class CamaraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('camaras')->insert([
            'nombre' => "Camara 1",
            'estado' => "1",
        ]);
        DB::table('camaras')->insert([
            'nombre' => "Camara 2",
            'estado' => "1",
        ]);
        DB::table('camaras')->insert([
            'nombre' => "Camara 3",
            'estado' => "1",
        ]);
        DB::table('camaras')->insert([
            'nombre' => "Camara 4",
            'estado' => "1",
        ]);
        DB::table('camaras')->insert([
            'nombre' => "Invernadero",
            'estado' => "1",
        ]);
        DB::table('camaras')->insert([
            'nombre' => "Piletonoes",
            'estado' => "1",
        ]);
    }
}
