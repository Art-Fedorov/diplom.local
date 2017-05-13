<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Админ Иванов',
            'email' => 'admin@mail.ru',
            'password' => bcrypt('111111'),
            'role' => 'admin',
            'id_group' => '22',
        ]);
        DB::table('users')->insert([
            'name' => 'Редактор Иванов',
            'email' => 'redactIvanov@mail.ru',
            'password' => bcrypt('111111'),
            'role' => 'teacher',
            'id_group' => '22',
        ]);
        DB::table('users')->insert([
            'name' => 'Студент Иванов',
            'email' => 'studentIvanov@mail.ru',
            'password' => bcrypt('111111'),
            'role' => 'user',
            'id_group' => '22',
        ]);
        DB::table('users')->insert([
            'name' => 'Студент Петров',
            'email' => 'studentPetrov@mail.ru',
            'password' => bcrypt('111111'),
            'role' => 'user',
            'id_group' => '22',
        ]);
        DB::table('users')->insert([
            'name' => 'Студент Сидоров',
            'email' => 'studentSidorov@mail.ru',
            'password' => bcrypt('111111'),
            'role' => 'user',
            'id_group' => '23',
        ]);
        DB::table('users')->insert([
            'name' => 'Василий Григорьев',
            'email' => 'grigor@mail.ru',
            'password' => bcrypt('111111'),
            'role' => 'user',
            'id_group' => '23',
        ]);
    }
}
