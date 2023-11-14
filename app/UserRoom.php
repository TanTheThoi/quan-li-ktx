<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoom extends Model
{
    protected $table = "user_room";
    protected $primaryKey = 'id';

    protected $fillable = ['user_id','phong_id','start_date','end_date','thanhtoan','status'];

    public function user(){
        return $this->hasMany('App\users','id','user_id');
    }
    public function room(){
        return $this->hasMany('App\phong','id','phong_id');
    }
}
