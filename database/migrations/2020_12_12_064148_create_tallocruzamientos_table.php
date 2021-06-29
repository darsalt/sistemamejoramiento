<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTallocruzamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tallocruzamientos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idtallo')->unsigned();
            $table->timestamps();
        });

        Schema::table('tallocruzamientos', function (Blueprint $table) {
            $table->foreign('idtallo')->references('id')->on('tallos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tallocruzamientos');
    }
}
