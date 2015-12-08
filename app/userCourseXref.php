<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userCourseXref extends Model
{
    public $timestamps = false;
    protected $fillable = ['userID','courseID'];

}
