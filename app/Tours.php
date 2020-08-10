<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tours extends Model
{

    use SoftDeletes;

    protected $fillable = [
        'start',
        'end',
        'price'
    ];
}
