<?php

use Illuminate\Database\Seeder;

class AlgorithmsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('algorithms')->insert([
            'name' => 'Классический',
            'desc' => '',
        ]);
        DB::table('algorithms')->insert([
            'name' => 'Тест-сопоставление',
            'desc' => '',
        ]);
    }
}
