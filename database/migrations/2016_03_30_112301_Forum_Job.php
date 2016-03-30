<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumJob extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Forum_Job', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_forum')->unsigned();
            $table->foreign('id_forum')->references('id')->on('Forum');
            $table->integer('id_job')->unsigned();
            $table->foreign('id_job')->references('id')->on('Job');
            $table->timestamps();

            $table->primary('id');
            $table->primary('id_forum');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Forum_Job');
    }
}
