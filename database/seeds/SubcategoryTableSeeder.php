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
        $category = DB::table('Category')->get();
        $category_count = count($category);
        $category_random = mt_rand(0, $category_count-1);

        DB::table('subcategory')->insert([
            'title' => 'Subcategory_' . str_random(10),
            'category_id' => $category[$category_random]->id,
        ]);
    }
}