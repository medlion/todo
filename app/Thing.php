<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thing extends Model
{
    //
    protected $attributes = [
        'completed' => false,
        'parent' => -1
    ];

    protected $fillable = [
        'description',
        'completed',
        'parent'
    ];
}
