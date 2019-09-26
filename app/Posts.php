<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
class Posts extends Model
{
    protected $fillable = [
        'title',
        'body',
        'post_type',
        'user_id',
        'status',
    ];
    // comments
    protected $table = 'posts'; // if defferent

    public function photos(){
      return $this->morphMany('App\Photo','imageable');
    }

    public function author()
    {
        return $this->belongsTo('App\Admins','user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comments','post_id');
    }

    public function types()
    {
        return $this->belongsTo('App\PostType','post_type');
    }
    public function votes()
    {
        return $this->hasMany('App\PostVote','post_id');
    }
    public function options()
    {
        return $this->hasMany('App\PostOption','post_id');
    }
    public function getCreatedAtAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('M d, Y');
    }
}
