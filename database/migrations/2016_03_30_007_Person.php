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
            $table->text('signup_comment');
            $table->timestamp('birthday');
            $table->string('Twitter');
            $table->string('Facebook');
            $table->string('LinkedIn');
            $table->string('Xing');
            $table->tinyInteger('accepted');
            $table->timestamp('accepted_at');
            $table->timestamp('requested_at');
            $table->timestamp('token_refresh');
            $table->rememberToken();
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
        Schema::drop('Person');
    }
}
