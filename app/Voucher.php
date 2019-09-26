<?php

namespace App;
use App\BrandNews;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $primaryKey = 'vou_id';
    protected $table = 'lo_vouchers';
    protected $fillable = [
        'vou_code',
        'vou_type',
        'disc_per',
        'disc_value',
        'active_fdate',
        'active_tdate',
        'all_cust',
        'forcust_phone',
      ];
    public $timestamps = false;
    // public function getForcustPhoneAttribute($value){
    //     return $value;
    // }

    protected $dates = ['active_fdate', 'active_tdate'];
    public function getVouTypeAttribute($value){
      if($value == 1){
        return 'Percent';
      }else{
        return 'Value';
      }
    }
    public function getActiveFdateAttribute($value){
        return date('d M, Y', strtotime($value));
    }
    public function getActiveTdateAttribute($value){
        return date('d M, Y', strtotime($value));
    }

    public function getAllCustAttribute($value){
        if($value == 1){
          return 'All Customers';
        }else{
          return $this->forcust_phone;
        }
    }
}
