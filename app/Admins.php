<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
  //
  protected $table = 'users';
  protected $fillable = [
      'email',
      'password',
      'active',
      'user_level',
      'first_name',
      'last_name',
      'imagePath',
      'activation_code',
  ];


  public function Replier()
  {

      return $this->hasMany('App\Replies','user_id');
  }

  public function role()
  {
      return $this->hasOne('App\Replies','role_id');
  }

  public function Commenter()
  {

      return $this->hasMany('App\Comments','user_id');

  }

  public function posts()
  {

      return $this->hasMany('App\Posts','user_id');

  }

  public function getNameAttribute($value){
      return $this->first_name.' '.$this->last_name;
  }
  public function getActiveAttribute($value){

      if($value == 1){

        return 'Enable';

      }

      else{
        return 'Disable';
      }
  }
}
