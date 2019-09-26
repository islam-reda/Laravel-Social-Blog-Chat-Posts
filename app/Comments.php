<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table = 'comments';
    protected $fillable = ['body','post_id','user_id'];

    public function replies()
    {
        return $this->hasMany('App\Replies','comment_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Admins','user_id');
    }

    public function post()
    {
        return $this->belongsTo('App\Posts','post_id');
    }

    public function CommentedUsers()
    {
        return $this->belongsTo('App\Admins');
    }

}
