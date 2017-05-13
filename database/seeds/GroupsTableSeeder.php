<?php

use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->insert([
            'group' => '13ПИ',
            'desc' => 'Программная инженерия',
            'start_year' => '2013-09-01',
            'end_year' => '2017-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '13ИВ',
            'desc' => 'Информатика и вычислительная техника',
            'start_year' => '2013-09-01',
            'end_year' => '2017-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '13ИС',
            'desc' => 'Информационные системы и технологии',
            'start_year' => '2013-09-01',
            'end_year' => '2017-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '14ПИ',
            'desc' => 'Программная инженерия',
            'start_year' => '2014-09-01',
            'end_year' => '2018-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '14ИВ',
            'desc' => 'Информатика и вычислительная техника',
            'start_year' => '2014-09-01',
            'end_year' => '2018-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '14ИС',
            'desc' => 'Информационные системы и технологии',
            'start_year' => '2014-09-01',
            'end_year' => '2018-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '15ПИ',
            'desc' => 'Программная инженерия',
            'start_year' => '2015-09-01',
            'end_year' => '2019-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '15ИВ',
            'desc' => 'Информатика и вычислительная техника',
            'start_year' => '2015-09-01',
            'end_year' => '2019-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '15ИС',
            'desc' => 'Информационные системы и технологии',
            'start_year' => '2015-09-01',
            'end_year' => '2019-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '16ПИ',
            'desc' => 'Программная инженерия',
            'start_year' => '2016-09-01',
            'end_year' => '2020-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '16ИВ',
            'desc' => 'Информатика и вычислительная техника',
            'start_year' => '2016-09-01',
            'end_year' => '2020-09-01',
        ]);
        DB::table('groups')->insert([
            'group' => '16ИС',
            'desc' => 'Информационные системы и технологии',
            'start_year' => '2016-09-01',
            'end_year' => '2020-09-01',
        ]);
    }
}
