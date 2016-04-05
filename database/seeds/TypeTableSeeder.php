<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Type')->insert([
            'title' => str_random(10),
            'description' => str_random(10)
        ]);
    }
}