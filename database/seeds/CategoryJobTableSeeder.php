<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoryJobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = DB::table('Category')->get();
        $category_count = count($category);
        $category_random = mt_rand(0, $category_count-1);

        $job = DB::table('Job')->get();
        $job_count = count($job);
        $job_random = mt_rand(0, $job_count-1);

        DB::table('Category_Job')->insert([
            'category_id' => $category[$category_random]->id,
            'job_id' => $job[$job_random]->id
        ]);
    }
}