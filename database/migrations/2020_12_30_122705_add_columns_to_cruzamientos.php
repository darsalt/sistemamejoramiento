<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToCruzamientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cruzamientos', function (Blueprint $table) {
            $table->Integer('idpadre')->nullable();
            $table->Integer('idmadre')->nullable();
       
            $table->foreign('idpadre')->references('idtacho')->on('tachos');
            $table->foreign('idmadre')->references('idtacho')->on('tachos');
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
            $table->dropForeign(['idpadre']);
            $table->dropForeign(['idmadre']);
            $table->dropColumn('idpadre');
            $table->dropColumn('idmadre');
        });
    }
}
