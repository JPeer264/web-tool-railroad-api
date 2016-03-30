<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ForumCompany extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Forum_Company', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_forum')->unsigned();
            $table->foreign('id_forum')->references('id')->on('Forum');
            $table->integer('id_company')->unsigned();
            $table->foreign('id_company')->references('id')->on('Company');
            $table->timestamps();

            $table->primary('id');
            // $table->primary('id_forum');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Forum_Company');
    }
}
