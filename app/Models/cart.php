<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'price',
        'quantity'
    ];

    public function user(){
       return $this->belongsTo(User::class);
    }
}
