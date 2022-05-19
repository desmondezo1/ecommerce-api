<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class partner extends Model
{
    protected $fillable = [
        'photo',
        'name',
    ];

    protected $table = "brands";
}
