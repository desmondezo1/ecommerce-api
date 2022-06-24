<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class billing_address extends Model
{
    protected $table = "billing_addresses";
    protected $guarded = [];

    public function user(){
        $this->hasOne(User::class);
    }
}
