<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Category')->delete();

        DB::table('Category')->insert([
            'title' => 'Conservation'
        ]);

        DB::table('Category')->insert([
            'title' => 'Documentation'
        ]);

        DB::table('Category')->insert([
            'title' => 'Investigation'
        ]);

        DB::table('Category')->insert([
            'title' => 'Diffusion'
        ]);

        DB::table('Category')->insert([
            'title' => 'Education'
        ]);

        DB::table('Category')->insert([
            'title' => 'Cultural Animation (Activities)'
        ]);
    }
}