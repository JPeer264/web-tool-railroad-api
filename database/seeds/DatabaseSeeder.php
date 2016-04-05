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
        $this->call('CategoryTableSeeder');
        $this->call('JobTableSeeder');
        $this->call('TypeTableSeeder');
        $this->call('RoleTableSeeder');
        $this->call('CompanyTableSeeder');
        $this->call('PersonTableSeeder');
        $this->call('TopicTableSeeder');
        $this->call('CommentTableSeeder');
        $this->call('CategoryCompanyTableSeeder');
        $this->call('CategoryJobTableSeeder');
        $this->call('TopicCompanyTableSeeder');
        $this->call('TopicJobTableSeeder');
    }
}
