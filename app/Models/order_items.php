<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order_items extends Model
{
    protected $table = "order_items";
    protected $fillable = ["order_id", "product_id"];
}
