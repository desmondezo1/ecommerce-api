<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pieces extends Model
{
    protected $fillable = [
        'title',
        'price',
        'product_id',
        'description',
        'brand_id',
        'offer_price',
        'photo',
        'discount' ,
        'status',
        'category_id' ,
    ];
}
