<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'from_user_id',
        'to_user_id',
        'message',
        'is_read',
    ];
    public function fromuser()
    {
        return $this->belongsTo('App\Admins','from_user_id');
    }
    public function touser()
    {
        return $this->belongsTo('App\Admins','to_user_id');
    }
}
