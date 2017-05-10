<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Team extends Eloquent
{
    protected $collection = 'team';
	public $timestamps = false;

     public function user(){
        return $this->hasOne('App\Model\User','_id','userid');
    }
    
    public function match(){
        return $this->hasOne('App\Model\Match','_id','matchid');
    }
}
