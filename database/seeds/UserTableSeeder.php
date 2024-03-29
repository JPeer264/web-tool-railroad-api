<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
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

        DB::table('User')->insert([
            'company_id' => $company[$company_random]->id,
            'role_id' => 1,
            'job_id' => $job[$job_random]->id,
            'firstname' => 'Marlowe',
            'lastname' => 'Hubert',
            'password' => Hash::make('secret'),
            'gender' => 'male',
            'picture_alt' => str_random(10),
            'email' => 'superadmin@gmail.com',
            'country_id' => 724,
            'city' => 'Vilanova i la Geltrú',
            'address' => str_random(10),
            'signup_comment' => str_random(100),
            'twitter' => 'www.twitter.com',
            'facebook' => 'fb.me',
            'linkedin' => 'www.linkedin.com',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'accepted' => 2,
            'accepted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'requested_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $job_random = mt_rand(0, $job_count-1);
        $company_random = mt_rand(0, $company_count-1);

        DB::table('User')->insert([
            'company_id' => $company[$company_random]->id,
            'role_id' => 2,
            'job_id' => $job[$job_random]->id,
            'firstname' => 'Siv',
            'lastname' => 'Wenona',
            'password' => Hash::make('secret'),
            'gender' => 'female',
            'picture_alt' => str_random(10),
            'email' => 'admin@gmail.com',
            'country_id' => 724,
            'city' => 'Madrid',
            'address' => str_random(10),
            'signup_comment' => str_random(100),
            'twitter' => 'www.twitter.com',
            'facebook' => 'fb.me',
            'linkedin' => 'www.linkedin.com',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'accepted' => 2,
            'accepted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'requested_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $job_random = mt_rand(0, $job_count-1);
        $company_random = mt_rand(0, $company_count-1);

        DB::table('User')->insert([
            'company_id' => $company[$company_random]->id,
            'role_id' => 3,
            'job_id' => $job[$job_random]->id,
            'firstname' => 'Margarita',
            'lastname' => 'Louisette',
            'password' => Hash::make('secret'),
            'gender' => 'female',
            'picture_alt' => str_random(10),
            'email' => 'companyadmin@gmail.com',
            'country_id' => 724,
            'city' => 'Barcelona',
            'address' => str_random(10),
            'signup_comment' => str_random(100),
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'accepted' => 2,
            'accepted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'requested_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        $job_random = mt_rand(0, $job_count-1);
        $company_random = mt_rand(0, $company_count-1);

        DB::table('User')->insert([
            'company_id' => $company[$company_random]->id,
            'role_id' => 4,
            'job_id' => $job[$job_random]->id,
            'firstname' => 'User',
            'lastname' => str_random(5),
            'password' => Hash::make('secret'),
            'gender' => 'female',
            'email' => 'user@gmail.com',
            'country_id' => 724,
            'city' => 'A small city in spain',
            'address' => str_random(10),
            'signup_comment' => str_random(100),
            'birthday' => Carbon::now()->format('Y-m-d H:i:s'),
            'twitter' => 'www.twitter.com',
            'facebook' => 'fb.me',
            'linkedin' => 'www.linkedin.com',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'accepted' => 2,
            'accepted_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'requested_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('User')->insert([
            'company_id' => 1,
            'role_id' => 4,
            'job_id' => 1,
            'firstname' => 'User',
            'lastname' => str_random(5),
            'password' => Hash::make('secret'),
            'gender' => 'female',
            'email' => str_random(5) . '@gmail.com',
            'country_id' => 724,
            'city' => 'A small city in spain',
            'address' => str_random(10),
            'signup_comment' => str_random(100),
            'twitter' => 'www.twitter.com',
            'facebook' => 'fb.me',
            'linkedin' => 'www.linkedin.com',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'accepted' => mt_rand(0, 2),
            'requested_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        for ($i = 0; $i < 20; $i++) {
            $job_random = mt_rand(1, $job_count-1);
            $company_random = mt_rand(1, $company_count-1);

            DB::table('User')->insert([
                'company_id' => $company[$company_random]->id,
                'role_id' => 4,
                'job_id' => $job[$job_random]->id,
                'firstname' => 'User',
                'lastname' => str_random(5),
                'password' => Hash::make('secret'),
                'gender' => 'female',
                'email' => str_random(5) . '@gmail.com',
                'country_id' => 724,
                'city' => 'A small city in spain',
                'address' => str_random(10),
                'signup_comment' => str_random(100),
                'twitter' => 'www.twitter.com',
                'facebook' => 'fb.me',
                'linkedin' => 'www.linkedin.com',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'accepted' => mt_rand(0, 2),
                'requested_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}