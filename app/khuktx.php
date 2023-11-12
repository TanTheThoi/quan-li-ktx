<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class khuktx extends Model
{
    protected $table = "khuktx";
    protected $guarded = ['_token'];

    public $timestamps =false;

    public function phong(){
    	return $this->belongsTo('App\phong','mskhu','id');
    }
}
