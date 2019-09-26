<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{

    protected $fillable = ['imagePath','author','content','from_user_id','to_users_id'];

}
