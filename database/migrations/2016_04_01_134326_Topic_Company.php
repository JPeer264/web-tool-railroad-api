<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TopicCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('Topic_Company', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('topic_id')->unsigned();
          $table->foreign('topic_id')->references('id')->on('Topic');
          $table->integer('company_id')->unsigned();
          $table->foreign('company_id')->references('id')->on('Company');
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
      Schema::drop('Topic_Company');

    }
}
