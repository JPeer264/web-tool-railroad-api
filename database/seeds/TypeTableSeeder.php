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
            'title' => 'Typetitle_'.str_random(10),
            'description' => 'Typedescription_' . str_random(10)
        ]);
    }
}