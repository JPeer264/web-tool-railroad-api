<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subcategory')->insert([
            'title' => str_random(10)
        ]);
    }
}