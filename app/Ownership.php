<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ownership extends Model
{
    //
    public $timestamps = false;

    protected $fillable = [
        'thing',
        'user'
    ];
}
