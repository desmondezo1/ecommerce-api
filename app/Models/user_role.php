<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class user_role extends Model
{
    protected $table = 'user_roles';

    public function users(){
        $this->hasMany(User::class);
    }
}
