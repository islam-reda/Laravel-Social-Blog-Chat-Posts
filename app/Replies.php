<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Replies extends Model
{
  // comments
    protected $table = 'replies';
    protected $fillable = ['body','user_id','comment_id'];


  public function user()
  {
      return $this->belongsTo('App\Admins','user_id');
  }
  public function comment()
  {
      return $this->belongsTo('App\Comments','comment_id');
  }
}
