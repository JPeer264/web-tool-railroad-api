<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   

        $role = DB::table('Role')->get();
        $role_count = count($role);
        $maximum_count = 4;

        // prevent that role count is more than 4
        if ($role_count >= $maximum_count) return;

        DB::table('Role')->insert([
            'id' => 1,
            'name' => 'Superadmin',
            'description' => 'Have all rights!'
        ]);

        DB::table('Role')->insert([
            'id' => 2,
            'name' => 'Admin',
            'description' => 'Is not able to delete active users.'
        ]);

        DB::table('Role')->insert([
            'id' => 3,
            'name' => 'Companyadmin',
            'description' => 'Is able to add and delete members to his own company.'
        ]);

        DB::table('Role')->insert([
            'id' => 4,
            'name' => 'User',
            'description' => 'Can write topics in categories and comments in topics. Limit on his own job and company'
        ]);

    }
}