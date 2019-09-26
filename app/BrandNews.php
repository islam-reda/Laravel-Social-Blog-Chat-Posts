<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Session;
class BrandNews extends Model
{
    protected $primaryKey = 'ad_id'; // if defferent
    protected $fillable = [
        'brand_id',
        'start_date',
        'end_date',
        'active',
        'ad_title',
        'ad_desc1',
        'ad_img1',
        'ad_img2',
        'ad_img3',
      ];
      public $timestamps = false;
      protected $dates = ['start_date', 'end_date'];
      public function getAdImg1Attribute($value){
          return '/images'.'/'.$value;
      }
      public function getAdImg2Attribute($value){
          return '/images'.'/'.$value;
      }
      public function getAdImg3Attribute($value){
          return '/images'.'/'.$value;
      }
      public function getStartDateAttribute($value){
          return date('d M, Y', strtotime($value));
      }
      public function getEndDateAttribute($value){
          return date('d M, Y', strtotime($value));
      }
      public function getActiveAttribute($value){
          if($value == 1){
            return 'Enable';
          }else{
            return 'Disable';
          }
      }
      public function brand(){
        return $this->belongsTo('App\Brand','brand_id','brand_id'); // find user_id automatic in post || user_id for custom || id of post for custom
      }
}
