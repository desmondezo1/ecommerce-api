<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    protected $fillable =  ["trans_id","user_id","order_id","amount","trans_status"];
    //
}
