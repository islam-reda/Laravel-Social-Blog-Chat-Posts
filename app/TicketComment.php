<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class TicketComment extends Model
{
    protected $table = 'ticket_comment';

    protected $fillable = ['body','ticket_id','user_id'];

    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
    public function getUserIdAttribute($value){
          return User::find($value);
    }
    public function getCreatedAtAttribute($value){
        return date('d M, Y', strtotime($value));
    }
}
