<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoom extends Model
{
    protected $table = "user_room";
    protected $fillable = ['user_id','phong_id','start_date','end_date','thanhtoan'];

    public function user(){
        return $this->hasMany('App\users','id','user_id');
    }
}
