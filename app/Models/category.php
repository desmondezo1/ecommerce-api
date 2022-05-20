<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    protected $guarded = [];
    //
    public function products(){
        return $this->belongsToMany(product::class,'categories_products', 'category_id','product_id' );
    }

    public function parent(){
        return $this->hasMany(self::class);
        //uses parent_id to find the parent by 'id'
    }

    public function children(){
        return $this->hasMany(self::class, 'parent_id');
        //finds other records where their parent_id is the parent's 'id'
    }
}
