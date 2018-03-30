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

    public function posts()
    {
        return $this->hasMany("App\Post");
    }
    public function fans()
    {
        return $this->hasMany("App\Fan","star_id","id");
    }

    public function stars()
    {
        return $this->hasMany("App\Fan","fan_id","id");
    }
    //關注
    public function doFan($uid)
    {
        $fan = new Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }

    //取消關注
    public function doUnFan($uid)
    {
        $fan = new Fan();
        $fan->star_id = $uid;
        return $this->stars()->save($fan);
    }

    //當前用戶是否被uid關注
    public function hasFun($uid)
    {
        return $this->fans()->where("fan_id",$uid)->count();
    }

    //當前用戶是否關注了uid
    public function hasStar($uid)
    {
        return $this->stars()->where("star_id",$uid)->count();
    }


}
