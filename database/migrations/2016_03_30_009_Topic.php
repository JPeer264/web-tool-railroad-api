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
            $table->integer('subcategory_id')->unsigned();
            $table->foreign('subcategory_id')->references('id')->on('Subcategory');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('User');
            $table->integer('type_id')->unsigned()->default(1);
            $table->foreign('type_id')->references('id')->on('Type');
            $table->string('title');
            $table->string('description');
            $table->tinyInteger('is_closed')->nullable();
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
        Schema::drop('Topic');
    }
}
