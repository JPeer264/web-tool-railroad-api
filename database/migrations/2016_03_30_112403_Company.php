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
            $table->foreign('administrator')->references('id')->on('Person');
            $table->string('name');
            $table->string('logo_alt');
            $table->string('logo_location');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->string('phonenumber')->nullable();
            $table->string('email');
            $table->timestamps();

            $table->primary('id');

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
