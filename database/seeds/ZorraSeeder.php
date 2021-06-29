<?php

use Illuminate\Database\Seeder;

class ZorraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CAMARA 1 - zorras
        DB::table('zorras')->insert([
            'nombre' => "Zorra 1",
            'estado' => "1",
            'idcamara' => 1,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 2",
            'estado' => "1",
            'idcamara' => 1,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 3",
            'estado' => "1",
            'idcamara' => 1,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 4",
            'estado' => "1",
            'idcamara' => 1,
        ]);
        // CAMARA 2 - zorras
        DB::table('zorras')->insert([
            'nombre' => "Zorra 1",
            'estado' => "1",
            'idcamara' => 2,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 2",
            'estado' => "1",
            'idcamara' => 2,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 3",
            'estado' => "1",
            'idcamara' => 2,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 4",
            'estado' => "1",
            'idcamara' => 2,
        ]);
        // CAMARA 3 - zorras
        DB::table('zorras')->insert([
            'nombre' => "Zorra 1",
            'estado' => "1",
            'idcamara' => 3,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 2",
            'estado' => "1",
            'idcamara' => 3,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 3",
            'estado' => "1",
            'idcamara' => 3,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 4",
            'estado' => "1",
            'idcamara' => 3,
        ]);
        // CAMARA 4 - zorras
        DB::table('zorras')->insert([
            'nombre' => "Zorra 1",
            'estado' => "1",
            'idcamara' => 4,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 2",
            'estado' => "1",
            'idcamara' => 4,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 3",
            'estado' => "1",
            'idcamara' => 4,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 4",
            'estado' => "1",
            'idcamara' => 4,
        ]);
        // Invernadero - zorras
        DB::table('zorras')->insert([
            'nombre' => "Zorra 1",
            'estado' => "1",
            'idcamara' => 5,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 2",
            'estado' => "1",
            'idcamara' => 5,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 3",
            'estado' => "1",
            'idcamara' => 5,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 4",
            'estado' => "1",
            'idcamara' => 5,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 5",
            'estado' => "1",
            'idcamara' => 5,
        ]);
        DB::table('zorras')->insert([
            'nombre' => "Zorra 6",
            'estado' => "1",
            'idcamara' => 5,
        ]);
    }
}
