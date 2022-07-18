<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = "products";
    protected $guarded = [];
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
        'pdf',
        'surface',
        'weight',
        'packaging',
        'tag',
        'title',
        'uses',
        'volume'
    ];

    public function category(){
        return $this->belongsToMany(category::class, 'categories_products', 'product_id', 'category_id');
    }


    public function images()
    {
        return $this->hasMany(productImages::class, 'product_id');
    }
}

