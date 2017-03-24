<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('id_user')
                ->unsigned();
            $table->foreign('id_user')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            $table->text('desc')
                ->nullable();
            $table->integer('maxmark')
                ->default(10);
            $table->string('slug',50)
                ->unique();
            $table->integer('id_alg')
                ->default(1);
            $table->timestamp('published_at')
                ->nullable();
            $table->boolean('published')
                ->default(false);
            $table->boolean('archive')
                ->default(false);
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
        Schema::drop('tests');
    }
}
