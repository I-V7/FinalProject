<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userTeamXref extends Model
{
    public $timestamps = false;
    protected $fillable = ['userID', 'teamID'];
}
