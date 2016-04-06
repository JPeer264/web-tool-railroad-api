<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TopicTableSeeder extends Seeder
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

        $user = DB::table('User')->get();
        $user_count = count($user);
        $user_random = mt_rand(0, $user_count-1);

        $type = DB::table('Type')->get();
        $type_count = count($type);
        $type_random = mt_rand(0, $type_count-1);

        DB::table('Topic')->insert([
            'category_id' => $category[$category_random]->id,
            'user_id' => $user[$user_random]->id,
            'type_id' => $type[$type_random]->id,
            'title' => str_random(10),
            'description' => str_random(10),
            'is_closed' => false,
            'is_deleted' => false
        ]);
    }
}