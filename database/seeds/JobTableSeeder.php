<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Job')->insert([
            'title' => str_random(10),
            'description' => str_random(10)
        ]);
    }
}