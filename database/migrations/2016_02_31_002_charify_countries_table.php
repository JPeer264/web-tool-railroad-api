<?php

use Illuminate\Database\Migrations\Migration;

class CharifyCountriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return  void
	 */
	public function up()
	{
            Schema::table('Countries', function($table)
            {
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY country_code CHAR(3) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY iso_3166_2 CHAR(2) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY iso_3166_3 CHAR(3) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY region_code CHAR(3) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY sub_region_code CHAR(3) NOT NULL DEFAULT ''");
            });
        }
	

	/**
	 * Reverse the migrations.
	 *
	 * @return  void
	 */
	public function down()
	{
            Schema::table('Countries', function($table)
            {
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY country_code VARCHAR(3) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY iso_3166_2 VARCHAR(2) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY iso_3166_3 VARCHAR(3) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY region_code VARCHAR(3) NOT NULL DEFAULT ''");
                DB::statement("ALTER TABLE " . DB::getTablePrefix() . 'Countries' . " MODIFY sub_region_code VARCHAR(3) NOT NULL DEFAULT ''");
            });
	}

}
