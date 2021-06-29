<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarTachoIdAUbicacionestachos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ubicacionestachos', function (Blueprint $table) {
            $table->Integer('idtacho');
            $table->foreign('idtacho')->references('idtacho')->on('tachos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ubicacionestachos', function (Blueprint $table) {
            $table->dropForeign(['idtacho']);
        });
    }
}
