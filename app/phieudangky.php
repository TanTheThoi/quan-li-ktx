<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phieudangky extends Model
{
    protected $table = "phieudangky";
    protected $fillable = ['student_id','room_id','status','start_date','end_date'];
    public function room(){
        return $this->belongsTo('App\phong','room_id','id');
    }
    public function student(){
        return $this->belongsTo('App\users','student_id','id');
    }
    public function getStatus(){
        return $this->belongsTo('App\UserRoom', 'student_id', 'user_id');
    }


}
