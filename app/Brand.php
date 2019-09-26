<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $primaryKey = 'brand_id';
    protected $table = 'lo_brands';
    protected $fillable = [
        'brand_name',
        'brand_logofile',
        'active',
        'activation_code',
        'created_date',
      ];
    public $timestamps = false;
    public function getBrandLogofileAttribute($value){
        return '/images'.'/'.$value;
    }
    // one to many
    public function news(){
      return $this->hasMany('App\BrandNews','brand_id','brand_id'); // find user_id automatic in post || user_id for custom || id of post for custom
    }
    public function getActiveAttribute($value){
        if($value == 1){
          return 'Enable';
        }else{
          return 'Disable';
        }
    }
}
