<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Topic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Topic', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_category')->unsigned();
            $table->foreign('id_category')->references('id')->on('Category');
            $table->integer('id_person')->unsigned();
            $table->foreign('id_person')->references('id')->on('Person');
            $table->integer('id_type')->unsigned();
            $table->foreign('id_type')->references('id')->on('Type');
            $table->string('title');
            $table->string('description');
            $table->tinyInteger('is_closed');
            $table->tinyInteger('is_deleted');
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
        Schema::drop('Topic');
    }
}
