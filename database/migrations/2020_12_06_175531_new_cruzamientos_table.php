<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewCruzamientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cruzamientos', function (Blueprint $table) {
            $table->id();
            $table->string('tipocruzamiento');
            $table->integer('cruza');
            $table->integer('cubiculo');
            $table->date('fechacruzamiento');
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
        Schema::dropIfExists('cruzamientos');
    }
}
