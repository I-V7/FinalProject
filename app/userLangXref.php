<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userLangXref extends Model
{
    public $timestamps = false;
    protected $fillable = ['userID', 'langID'];
}
