<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('User', function (Blueprint $table) {
            $table->increments('id');
            
            $table->integer('company_id')->unsigned();
            $table->foreign('company_id')
                ->references('id')->on('Company');

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')
                ->references('id')->on('Role');

            $table->integer('job_id')->unsigned();
            $table->foreign('job_id')
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
        Schema::drop('User');
    }
}
