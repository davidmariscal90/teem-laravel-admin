<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Subsport extends Eloquent
{
    protected $collection = 'subsport';
	public $timestamps = false;
    protected $fillable =['title','value','sportid'];
    
    public function match(){
        return $this->hasOne('App\Model\Match','subsportid','id');
    }
}
