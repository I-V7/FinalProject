<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('password');
            $table->string('userType');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('language1');
            $table->string('language2');
            $table->string('language3');
            $table->string('teamStyle1');
            $table->string('teamStyle2');
            $table->string('teamStyle3');
            $table->string('email')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
