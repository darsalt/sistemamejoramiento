<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatossanitariospTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datossanitariosp', function (Blueprint $table) {
            $table->id();
            $table->integer('idtacho');
            $table->integer('idevaluacion');
            $table->integer('carbon')->nullable();
            $table->integer('escaladura')->nullable();
            $table->integer('estriaroja')->nullable();
            $table->integer('mosaico')->nullable();
            $table->integer('royamarron')->nullable();
            $table->integer('royaanaranjada')->nullable();
            $table->integer('pokkaboeng')->nullable();
            $table->integer('amarillamiento')->nullable();
            $table->integer('manchaparda')->nullable();
            $table->string('otra')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datossanitariosp');
    }
}
