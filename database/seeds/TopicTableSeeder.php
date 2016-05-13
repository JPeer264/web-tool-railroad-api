<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class TopicTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $subcategory = DB::table('Subcategory')->get();
        $subcategory_count = count($subcategory);

        $user = DB::table('User')->get();
        $user_count = count($user);

        $type = DB::table('Type')->get();
        $type_count = count($type);

        $count = 1;
        for ($i = 0; $i < $subcategory_count * 2; $i++) {
            if ($i % 2 == 0 && $i != 0) {
                $count++;
            }

            $user_random = mt_rand(0, $user_count-1);
            $type_random = mt_rand(0, $type_count-1);

            DB::table('Topic')->insert([
                'subcategory_id' => $count,
                'user_id' => $user[$user_random]->id,
                'type_id' => $type[$type_random]->id,
                'title' => 'Topicttitle_' . str_random(10),
                'description' => 'This topic focuses on something',
                'is_closed' => false,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]);
        }

    }
}