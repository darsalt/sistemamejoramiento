<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdCampaniacamaratratamientoubicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('campaniacamaratratamientoubicacion', function (Blueprint $table) {
            $table->BigInteger('idcampania')->nullable()->unsigned();
            $table->BigInteger('idcamara')->nullable()->unsigned();
            $table->Integer('idtratamiento');
            
       
            $table->foreign('idcampania')->references('id')->on('campanias');
            $table->foreign('idcamara')->references('id')->on('camaras');
            $table->foreign('idtratamiento')->references('idtratamiento')->on('tratamientos');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('campaniacamaratratamientoubicacion', function (Blueprint $table) {
            $table->dropForeign(['idcampania']);
            $table->dropForeign(['idcamara']);
            $table->dropForeign(['idtratamiento']);
            
            $table->dropColumn('idcampania');
            $table->dropColumn('idcamara');
            $table->dropColumn('idtratamiento');
            
        });
    }
}
