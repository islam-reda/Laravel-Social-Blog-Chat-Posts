<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    //
    protected $primaryKey = 'store_no';
    protected $table = 'lo_brand_stores';
    protected $fillable = [
        'brand_id',
        'store_code',
        'store_name',
        'store_loc_lat',
        'store_loc_lon',
        'active',
        'store_region',
        'store_addr1',
    ];
    public $timestamps = false;
    public function getActiveAttribute($value){
        if($value == 1){
          return 'Enable';
        }else{
          return 'Disable';
        }
    }
}
