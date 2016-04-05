<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class PersonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $job = DB::table('Job')->get();
        $job_count = count($job);
        $job_random = mt_rand(0, $job_count-1);

        $company = DB::table('Company')->get();
        $company_count = count($company);
        $company_random = mt_rand(0, $company_count-1);

        $role = DB::table('Role')->get();
        $role_count = count($role);
        $role_random = mt_rand(0, $role_count-1);

        DB::table('Person')->insert([
            'id_company' => $company[$company_random]->id,
            'id_role' => $role[$role_random]->id,
            'id_job' => $job[$job_random]->id,
            'firstname' => str_random(10),
            'lastname' => str_random(10),
            'password' => 'secret',
            'gender' => 'male',
            'picture_alt' => str_random(10),
            'picture_location' => '/path/to/picture/',
            'email' => str_random(10).'@gmail.com',
            'country' => str_random(10),
            'city' => str_random(10),
            'address' => str_random(10),
            'signup_comment' => str_random(100),
            'birthday' => mt_rand(1000000, 9999999),
            'Twitter' => 'www.twitter.com',
            'Facebook' => 'fb.me',
            'LinkedIn' => 'www.linkedin.com',
            'Xing' => 'www.xing.com',
            'accepted' => mt_rand(1000000, 9999999),
            'accepted_at' => mt_rand(1000000, 9999999),
            'requested_at' => mt_rand(1000000, 9999999),
            'token_refresh' => str_random(20),
        ]);
    }
}