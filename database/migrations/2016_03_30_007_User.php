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
            $table->string('gender', 10)->nullable();
            $table->string('picture_alt')->nullable();
            $table->string('picture_location')->nullable();
            $table->string('email');
            $table->integer('country_id')->unsigned();
            $table->string('city')->nullable();
            $table->string('address')->nullable();
            $table->text('signup_comment')->nullable();
            $table->timestamp('birthday')->nullable();
            $table->string('Twitter')->nullable();
            $table->string('Facebook')->nullable();
            $table->string('LinkedIn')->nullable();
            $table->string('Xing')->nullable();
            $table->tinyInteger('accepted')->default(false);
            $table->timestamp('accepted_at')->nullable();
            $table->timestamp('requested_at')->nullable();
            $table->rememberToken();
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
        Schema::drop('User');
    }
}
