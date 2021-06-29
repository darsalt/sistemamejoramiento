<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ChangeTallosPolenDatatype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tallos', function (Blueprint $table) {
            DB::statement("ALTER TABLE tallos MODIFY polen integer");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tallos', function (Blueprint $table) {
            DB::statement("ALTER TABLE tallos MODIFY polen varchar(255)");
        });
    }
}
