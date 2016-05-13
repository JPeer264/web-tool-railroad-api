<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
            'title' => 'Conservation',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('Category')->insert([
            'title' => 'Documentation',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('Category')->insert([
            'title' => 'Investigation',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('Category')->insert([
            'title' => 'Diffusion',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('Category')->insert([
            'title' => 'Education',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);

        DB::table('Category')->insert([
            'title' => 'Cultural Animation (Activities)',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}