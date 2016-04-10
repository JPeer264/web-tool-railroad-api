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
        $maximum_count = 5;

        // prevent that role count is more than 5
        if ($role_count >= $maximum_count) return;

        for ($i = 1; $i <= $maximum_count; $i++) {
            DB::table('Role')->insert([
                'name' => str_random(10),
                'description' => str_random(10),
                'ranking' => $i
            ]);
        }
    }
}