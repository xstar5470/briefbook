<?php

namespace App;

use Illuminate\Foundation\Auth\User as  Authenticatable;
class User extends Authenticatable
{
    protected $fillable = [
        "name","password","email"
    ];
    public function setPasswordAttribute($val)
    {
        $this->attributes['password'] = bcrypt($val);
    }
}
