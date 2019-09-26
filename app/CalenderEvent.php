<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalenderEvent extends Model
{
    protected $table = 'calenderevents';

    protected $fillable = [
        'title',
        'start',
        'end',
        'uid',
    ];


    public  function users(){
       return $this->belongsToMany(User::class);
    }

}
