<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Person extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Person', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('id_company')->unsigned();
            $table->foreign('id_company')
                ->references('id')->on('Company');

            $table->integer('id_role')->unsigned();
            $table->foreign('id_role')
                ->references('id')->on('Role');

            $table->integer('id_job')->unsigned();
            $table->foreign('id_job')
                ->references('id')->on('Job');

            $table->integer('id_socialmedia')->unsigned();
            $table->foreign('id_socialmedia')
                ->references('id')->on('SocialMedia');

            $table->string('firstname');
            $table->string('lastname');
            $table->string('password');
            $table->string('gender', 10);
            $table->string('picture_alt');
            $table->string('picture_location');
            $table->string('email');
            $table->string('country');
            $table->string('city');
            $table->string('address');
            $table->timestamp('birthday');
            $table->rememberToken();
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
        Schema::drop('Person');
    }
}
