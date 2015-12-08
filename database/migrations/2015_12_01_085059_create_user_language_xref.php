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
        Schema::create('user_lang_xref', function (Blueprint $table) {
            $table->integer('userID');
            $table->integer('langID');
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('langID')->references('id')->on('languages');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_lang_xref');
    }
}
