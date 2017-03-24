<?php

use Illuminate\Database\Seeder;
use App\Models\Test;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();
        // $this->call(UsersTableSeeder::class);
        //$this->call('TestSeeder');
    }
}

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    }
}