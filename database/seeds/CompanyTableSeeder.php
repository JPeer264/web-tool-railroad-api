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
            'name' => 'Museum Vilanova i la Geltrú',
            'logo_alt' => 'Picture Mueseum Vilanova',
            'country' => 'Spain',
            'city' => 'Vilanova',
            'phonenumber' => mt_rand(1000000, 9999999)
        ]);
    }
}