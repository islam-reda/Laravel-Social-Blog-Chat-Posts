<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    //
    protected $table = 'post_type';
    public function post()
 {
     return $this->hasOne('App\Posts','post_type');
 }
}
