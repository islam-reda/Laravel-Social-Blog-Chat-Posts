<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Ticket extends Model
{

    //$table->increments('id');
    //$table->string('title');
    //$table->string('description');
    //$table->integer('user_id');
    //$table->integer('type_id');
    //$table->string('area');
    //$table->string('status');

    protected $fillable = [
        'description', 'title', 'user_id','type_id','area','status'
    ];

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }
    public function areatb()
    {
        return $this->belongsTo('App\TicketArea','area');
    }
    public function statustb()
    {
        return $this->belongsTo('App\TicketStatus','status');
    }
    public function typetb()
    {
        return $this->belongsTo('App\TicketType','type_id');
    }
    public function photos(){
      return $this->morphMany('App\Photo','imageable');
    }
    public function getCreatedAtAttribute($value){
        return date('d M, Y', strtotime($value));
    }
    public function comments()
    {
        return $this->hasMany('App\TicketComment','ticket_id');
    }
}
