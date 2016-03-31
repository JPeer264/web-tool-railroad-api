<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Role extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Role', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rolename');
            $table->string('description');
            $table->tinyInteger('ranking'); //1 - 5 | Admin - User - etc.
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
        Schema::drop('Role');
    }
}
