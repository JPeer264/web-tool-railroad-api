<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TopicJobTableSeeder extends Seeder
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

        $job = DB::table('Job')->get();
        $job_count = count($job);
        $job_random = mt_rand(0, $job_count-1);

        DB::table('Topic_Job')->insert([
            'topic_id' => $topic[$topic_random]->id,
            'job_id' => $job[$job_random]->id
        ]);
    }
}