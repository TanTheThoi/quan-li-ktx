<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class phong extends Model
{
    protected $table = "phong";
    public $timestamps = false;
    protected $fillable = ['id','sophong','id_khu','sncur','snmax','gioitinh'];


    public function khuktx(){
    	return $this->hasOne('App\khuktx','id','id_khu');
    }

}
