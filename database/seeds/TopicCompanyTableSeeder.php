<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class TopicCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = DB::table('Company')->get();
        $company_count = count($company);
        $company_random = mt_rand(0, $company_count-1);

        $topic = DB::table('Topic')->get();
        $topic_count = count($topic);
        $topic_random = mt_rand(0, $topic_count-1);

        DB::table('Topic_Company')->insert([
            'topic_id' => $topic[$topic_random]->id,
            'company_id' => $company[$company_random]->id
        ]);
    }
}