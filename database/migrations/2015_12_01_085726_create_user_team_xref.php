<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTeamXref extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('userTeamXref', function (Blueprint $table) {
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('teamID')->references('id')->on('team');

        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userTeamXref');
    }
}
