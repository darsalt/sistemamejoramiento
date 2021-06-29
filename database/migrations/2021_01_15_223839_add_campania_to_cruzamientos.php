<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCampaniaToCruzamientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cruzamientos', function (Blueprint $table) {
            $table->bigInteger('idcampania')->unsigned()->nullable();
       
            $table->foreign('idcampania')->references('id')->on('campanias');
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
            $table->dropForeign(['idcampania']);
            $table->dropColumn('idcampania');
        });
    }
}
