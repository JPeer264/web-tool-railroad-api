<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TopicJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Topic_Job', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('id_topic')->unsigned();
          $table->foreign('id_topic')->references('id')->on('Topic');
          $table->integer('id_job')->unsigned();
          $table->foreign('id_job')->references('id')->on('Job');
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
