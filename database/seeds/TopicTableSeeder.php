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

        $person = DB::table('Person')->get();
        $person_count = count($person);
        $person_random = mt_rand(0, $person_count-1);

        $type = DB::table('Type')->get();
        $type_count = count($type);
        $type_random = mt_rand(0, $type_count-1);

        DB::table('Topic')->insert([
            'id_category' => $category[$category_random]->id,
            'id_person' => $person[$person_random]->id,
            'id_type' => $type[$type_random]->id,
            'title' => str_random(10),
            'description' => str_random(10),
            'is_closed' => false,
            'is_deleted' => false
        ]);
    }
}