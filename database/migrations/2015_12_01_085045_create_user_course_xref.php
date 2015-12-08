<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserCourseXref extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('userCourseXref', function (Blueprint $table) {
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('courseID')->references('id')->on('courses');

        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('userCourseXref');
    }
}
