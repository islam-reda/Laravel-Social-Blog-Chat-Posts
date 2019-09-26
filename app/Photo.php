<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //
    protected $table = 'photos'; // if defferent
    protected $fillable = ['path'];
    public function imageable(){

      return $this->morphTo();

    }
    public function getPathAttribute($value){
        return '/images'.'/'.$value;
    }
    public function getFullUrlAttribute($value){
        return '/images'.'/'.$value;
    }
}
