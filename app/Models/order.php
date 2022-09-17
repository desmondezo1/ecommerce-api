<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'payment_status',
        'product_id',
        'sub_total',
        'coupon',
        'total_amount',
        'quantity',
        'delivery_charge',
        'first_name',
        'last_name',
        'email',
        'phone',
        'address',
    ];

    public function status(){
        $this->hasOne(order_status::class,'status');
    }

    public function shippping_type(){
        $this->hasOne(shipping_type::class,'shipping_type');
    }
}
