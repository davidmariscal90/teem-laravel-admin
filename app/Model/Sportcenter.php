<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App\Observers\SportcenterObserver;

class Sportcenter extends Eloquent
{
    protected $collection = 'sportcenter';
	public $timestamps = false;

	protected $fillable = [
        'name', 'address', 'phone','description','lat','long','userid','ispublic','isreviewed'
    ];
	public static function boot(){

  		parent::boot();
  		
  		Sportcenter::observe(new SportcenterObserver());
		  
  	}
}
