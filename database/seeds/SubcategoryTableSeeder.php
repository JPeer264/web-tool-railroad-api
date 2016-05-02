<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SubcategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('Subcategory')->delete();

        $conservation = DB::table('Category')
            ->where('title', 'Conservation')
            ->get();


        DB::table('Subcategory')->insert([
            'title' => 'Normative (Local, European, International)',
            'category_id' => $conservation[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Conservation criteria',
            'category_id' => $conservation[0]->id,
        ]);


        $doc = DB::table('Category')
            ->where('title', 'Documentation')
            ->get();

        DB::table('Subcategory')->insert([
            'title' => 'Inventory (collection)',
            'category_id' => $doc[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Cataloguing',
            'category_id' => $doc[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Archive  (documents, photographs, etc)',
            'category_id' => $doc[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Library',
            'category_id' => $doc[0]->id,
        ]);

        $invest = DB::table('Category')
            ->where('title', 'Investigation')
            ->get();

        DB::table('Subcategory')->insert([
            'title' => 'History (Origen and development)',
            'category_id' => $invest[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Sources (oral and written)',
            'category_id' => $invest[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Manufacturing (systems, companies, series ...)',
            'category_id' => $invest[0]->id,
        ]);

        $diff = DB::table('Category')
            ->where('title', 'Diffusion')
            ->get();

        DB::table('Subcategory')->insert([
            'title' => 'Media relationship',
            'category_id' => $diff[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Web and social networks',
            'category_id' => $diff[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Publicity',
            'category_id' => $diff[0]->id,
        ]);

        $edu = DB::table('Category')
            ->where('title', 'Education')
            ->get();

        DB::table('Subcategory')->insert([
            'title' => 'Public  Types',
            'category_id' => $edu[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'General Public',
            'category_id' => $edu[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Families',
            'category_id' => $edu[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Schools',
            'category_id' => $edu[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Tourist',
            'category_id' => $edu[0]->id,
        ]);

        $conservation = DB::table('Category')
            ->where('title', 'Cultural Animation (Activities)')
            ->get();

        DB::table('Subcategory')->insert([
            'title' => 'Exhibitions (Permanent, Temporary,  roadshows…)',
            'category_id' => $conservation[0]->id,
        ]);

        DB::table('Subcategory')->insert([
            'title' => 'Virtual exhibitions',
            'category_id' => $conservation[0]->id,
        ]);
    }
}