<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App\Observers\MatchObserver;

class Match extends Eloquent
{
    protected $collection = 'match';
	public $timestamps = false;

    public function subsports(){
        return $this->hasOne('App\Model\Subsport','_id','subsportid');
    }

    public function sportcenter(){
        return $this->hasOne('App\Model\Sportcenter','_id','scid');
    }

	public static function boot(){
  		parent::boot();
  		Match::observe(new MatchObserver());
  	}
}
