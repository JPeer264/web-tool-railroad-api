<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Company extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('administrator')->unsigned();
            $table->string('name');
            $table->string('logo_alt');
            $table->string('logo_location');
            $table->integer('country_id')->unsigned();
            $table->string('city');
            $table->string('address');
            $table->string('Twitter')->nullable();
            $table->string('Facebook')->nullable();
            $table->string('LinkedIn')->nullable();
            $table->string('Xing')->nullable();
            // todo check if we can use -> laravel countries + prefixes for phonennumbers
            $table->string('phonenumber')->nullable();
            $table->string('email');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Company');
    }
}
