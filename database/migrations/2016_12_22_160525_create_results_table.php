<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_test')
                ->unsigned();
            $table->foreign('id_test')
                ->references('id')
                ->on('tests')
                ->onDelete('cascade');
            $table->integer('id_user')
                ->unsigned();
            $table->foreign('id_user')
                ->references('id')
                ->on('users');
            $table->integer('percent')->nullable();
            $table->integer('mark')->nullable();
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
        Schema::dropIfExists('results');
    }
}
