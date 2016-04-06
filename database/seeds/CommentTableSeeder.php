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

        $user = DB::table('User')->get();
        $user_count = count($user);
        $user_random = mt_rand(0, $user_count-1);

        DB::table('Comment')->insert([
            'user_id' => $user[$user_random]->id,
            'topic_id' => $topic[$topic_random]->id,
            'content' => str_random(10)
        ]);
    }
}