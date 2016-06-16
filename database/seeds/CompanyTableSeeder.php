<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Company')->insert([
            'name' => 'Company not listed',
        ]);

        DB::table('Company')->insert([
            'name' => 'Museum Vilanova i la Geltrú',
            'logo_alt' => 'Picture Mueseum Vilanova',
            'email' => 'museuferrocarril@ffe.es',
            'country_id' => 724,
            'city' => 'Vilanova',
            'twitter' => 'www.twitter.com',
            'facebook' => 'fb.me',
            'linkedin' => 'www.linkedin.com',
            'phonenumber' => mt_rand(1000000, 9999999)
        ]);

        DB::table('Company')->insert([
            'name' => 'Museum Madrid',
            'logo_alt' => 'Picture Mueseum Madrid',
            'country_id' => 724,
            'city' => 'Madrid',
            'phonenumber' => mt_rand(1000000, 9999999)
        ]);

        DB::table('Company')->insert([
            'name' => 'Museum Vienna',
            'logo_alt' => 'Picture Mueseum Vienna',
            'country_id' => 40,
            'city' => 'Madrid',
            'phonenumber' => mt_rand(1000000, 9999999)
        ]);
    }
}