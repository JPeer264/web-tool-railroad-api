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
            $table->foreign('id_category')->references('id')->on('Category');
            $table->foreign('id_person')->references('id')->on('Person');
            $table->string('title');
            $table->string('description');
            $table->tinyInteger('is_closed')
            $table->timestamps();

            $table->primary('id');

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
