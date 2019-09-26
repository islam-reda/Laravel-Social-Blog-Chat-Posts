<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostVote extends Model
{
    protected $table = 'post_votes';
    protected $fillable = [
        'option_id',
        'vote_user_id',
        'post_id',
        'status',
        'comment',
    ];
}
