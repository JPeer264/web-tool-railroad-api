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
          $table->integer('id_topic')->unsigned();
          $table->foreign('id_topic')->references('id')->on('Topic');
          $table->integer('id_company')->unsigned();
          $table->foreign('id_company')->references('id')->on('Company');
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
