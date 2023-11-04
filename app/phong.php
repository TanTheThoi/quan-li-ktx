<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phong extends Model
{
    protected $table = "phong";
    public $timestamps = false;
    protected $fillable = ['sophong','id_khu','sncur','snmax','gioitinh'];


    public function khuktx(){
    	return $this->hasOne('App\khuktx','id','id_khu');
    }

    public function user(){
        return $this->hasMany('App\UserRoom', 'phong_id', 'id')->where('end_date', '>=', date('Y-m-d'));
    }

}
