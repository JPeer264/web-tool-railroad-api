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
          $table->integer('topic_id')->unsigned();
          $table->foreign('topic_id')->references('id')->on('Topic');
          $table->integer('job_id')->unsigned();
          $table->foreign('job_id')->references('id')->on('Job');
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
