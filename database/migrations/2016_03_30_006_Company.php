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
            $table->string('country');
            $table->string('city');
            $table->string('address');
            // todo check if we can use -> laravel countries + prefixes for phonennumbers
            $table->string('phonenumber')->nullable();
            $table->string('email');
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