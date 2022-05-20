<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $fillable = [
        'title',
        'price',
        'description',
        'offer_price',
        'photo',
        'brand_id',
        'discount' ,
        'status',
        'category_id' ,
    ];

    public function category(){
        return $this->hasMany(category::class);
    }
}

