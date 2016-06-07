<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class JobTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $jobtitle = [
            'Head of Museum',
            'Supervisor',
            'Guide',
            'Manager',
            'Head of communication'
        ];
        DB::table('Job')->insert([
                'title' => 'Job not listed',
                'description' => "Job you can choose in case your job isn't available"
            ]);
        for ($i = 0; $i < 5; $i++) {
            $random_jobtitle = mt_rand(0, count($jobtitle)-1);
            DB::table('Job')->insert([
                'title' => $jobtitle[$random_jobtitle],
                'description' => 'Jobdescription_'.str_random(10)
            ]);
        }
    }
}