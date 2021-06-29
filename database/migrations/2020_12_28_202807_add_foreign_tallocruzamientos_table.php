<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignTallocruzamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tallocruzamientos', function (Blueprint $table) {
            $table->bigInteger('idcruzamiento')->unsigned();
        });

        Schema::table('tallocruzamientos', function (Blueprint $table) {
            $table->foreign('idcruzamiento')->references('id')->on('cruzamientos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cruzamientos', function (Blueprint $table) {
            $table->dropForeign(['idcruzamiento']);
            $table->dropColumn('idcruzamiento');
        });
    }
}
