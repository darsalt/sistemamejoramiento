<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdtallomadreTallocruzamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tallocruzamientos', function (Blueprint $table) {
            $table->bigInteger('idtallomadre')->unsigned()->after('idtallo');
        });

        Schema::table('tallocruzamientos', function (Blueprint $table) {
            $table->foreign('idtallomadre')->references('id')->on('tallos');
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
            $table->dropForeign(['idtallomadre']);
            $table->dropColumn('idtallomadre');
        });
    }
}
