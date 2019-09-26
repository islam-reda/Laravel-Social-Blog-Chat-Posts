<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostOption extends Model
{
    //
    protected $table = 'post_options';
    protected $fillable = ['post_id','name'];
    public function votes()
    {
        return $this->hasMany('App\PostVote','option_id');
    }
}
