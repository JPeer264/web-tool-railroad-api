<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Userlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Userlog', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('user_id')->unsigned();
          // $table->foreign('user_id')->references('id')->on('User');
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
      Schema::drop('Topic_Job');
    }
}
