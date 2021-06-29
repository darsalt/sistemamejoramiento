<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarCamaraIdToZorras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('zorras', function (Blueprint $table) {
            $table->BigInteger('idcamara')->unsigned();
            $table->foreign('idcamara')->references('id')->on('camaras');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('zorras', function (Blueprint $table) {
            $table->dropForeign(['idcamara']);
            $table->dropColumn('idcamara');
        });
    }
}
