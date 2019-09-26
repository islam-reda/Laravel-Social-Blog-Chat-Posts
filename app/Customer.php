<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $primaryKey = 'customer_phone'; // if defferent
    protected $table = 'loyalty_customers'; // if defferent
    protected $fillable = [
        'customer_phone',
        'active',
        'activation_code',
        'active_program_id',
        'prog_accm_points',
        'prog_accm_value',
        'prog_rdm_points',
        'prog_rdm_value',
        'last_up_invc_datetime',
        'last_up_invc_sid',
        'last_rdm_invc_datetime',
        'last_rdm_invc_sid',
        'brand_id',
        'email',
    ];
    public function getActiveAttribute($value){
        if($value == 1){
          return 'Enable';
        }else{
          return 'Disable';
        }
    }
    public $timestamps = false;
}
