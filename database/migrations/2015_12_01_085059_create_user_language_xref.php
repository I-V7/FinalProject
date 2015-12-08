<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLanguageXref extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('userLangXref', function (Blueprint $table) {
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('langID')->references('id')->on('languages');

        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userLangXref');
    }
}
