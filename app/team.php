<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class team extends Model
{
    public $timestamps = false;
    protected $fillable = ['teamName','teamType'];

}
