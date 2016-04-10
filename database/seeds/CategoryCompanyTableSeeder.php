<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoryCompanyTableSeeder extends Seeder
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

        $category = DB::table('Category')->get();
        $category_count = count($category);
        $category_random = mt_rand(0, $category_count-1);

        DB::table('Category_Company')->insert([
            'category_id' => $category[$category_random]->id,
            'company_id' => $company[$company_random]->id
        ]);
    }
}