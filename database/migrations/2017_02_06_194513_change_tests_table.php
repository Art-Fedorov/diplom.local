<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tests', function ($table) {
            $table->boolean('shuffle_questions')->nullable()->default(false)->after('archive');
            $table->boolean('shuffle_answers')->nullable()->default(false)->after('shuffle_questions');
            $table->boolean('view_right_answers')->nullable()->default(true)->after('shuffle_answers');
            $table->boolean('view_more_1_answer')->nullable()->default(false)->after('view_right_answers');
            $table->boolean('pass_other_questions')->nullable()->default(true)->after('view_more_1_answer');
            $table->string('time')->nullable()->default("00:30:00")->after('pass_other_questions');
            $table->dropColumn('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tests', function ($table) {
            $table->dropColumn('shuffle_questions');
            $table->dropColumn('shuffle_answers');
            $table->dropColumn('view_right_answers');
            $table->dropColumn('view_more_1_answer');
            $table->dropColumn('pass_other_questions');
            $table->dropColumn('time');
            $table->string('slug',50)
                ->unique();
        });
    }
}
