<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tours extends Model
{
    use SoftDeletes; 
    protected $table = 'tours';
    protected $fillable = [
        'id','start', 'end', 'price','created_at' ,'updated_at' ,'deleted_at'
    ];
    protected $dates = ['deleted_at'];
}
