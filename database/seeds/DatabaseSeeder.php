<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call('CountriesSeeder');
        $this->call('CategoryTableSeeder');
        $this->call('SubcategoryTableSeeder');
        $this->call('JobTableSeeder');
        $this->call('TypeTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('CompanyTableSeeder');
        $this->call('UserTableSeeder');
        $this->call('TopicTableSeeder');
        $this->call('CommentTableSeeder');
        $this->call('TopicCompanyTableSeeder');
        $this->call('TopicJobTableSeeder');
        $this->call('UserlogTableSeeder');
    }
}
