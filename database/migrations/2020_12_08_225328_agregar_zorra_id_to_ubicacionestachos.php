<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AgregarZorraIdToUbicacionestachos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ubicacionestachos', function (Blueprint $table) {
            $table->BigInteger('idzorra')->unsigned();
            $table->foreign('idzorra')->references('id')->on('zorras');
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
            $table->dropForeign(['idzorras']);
            $table->dropColumn('idzorras');
        });
    }
}
