<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CommentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $topic = DB::table('Topic')->get();
        $topic_count = count($topic);
        $topic_random = mt_rand(0, $topic_count-1);

        $person = DB::table('Person')->get();
        $person_count = count($person);
        $person_random = mt_rand(0, $person_count-1);

        DB::table('Comment')->insert([
            'id_person' => $person[$person_random]->id,
            'id_topic' => $topic[$topic_random]->id,
            'content' => str_random(10)
        ]);
    }
}