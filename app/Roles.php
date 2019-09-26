<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    //
    protected $primaryKey = 'level_id';
    protected $table = 'lo_user_level';
}
