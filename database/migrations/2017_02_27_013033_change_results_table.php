<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->integer('percent')->default(0)->change();
            $table->integer('mark')->default(0)->change();
            $table->boolean('passed')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('results', function (Blueprint $table) {
            $table->integer('percent')->default(null)->change();
            $table->integer('mark')->default(null)->change();
            $table->dropColumn('passed');
        });
    }
}
