<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdUbicaciontachoxcampaniaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ubicaciontachoxcampania', function (Blueprint $table) {
            $table->BigInteger('idubicacion')->nullable()->unsigned();
            $table->Integer('idtacho');
            $table->BigInteger('idcctu')->nullable()->unsigned();
       
            $table->foreign('idubicacion')->references('id')->on('ubicacionestachos');
            $table->foreign('idtacho')->references('idtacho')->on('tachos');
            $table->foreign('idcctu')->references('id')->on('campaniacamaratratamientoubicacion');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ubicaciontachoxcampania', function (Blueprint $table) {
            $table->dropForeign(['idubicacion']);
            $table->dropForeign(['idtacho']);
            $table->dropForeign(['idcctu']);
            
            $table->dropColumn('idubicacion');
            $table->dropColumn('idtacho');
            $table->dropColumn('idcctu');
            
        });
    }
}
