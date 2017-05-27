<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

use App\Observers\FieldObserver;

class Field extends Eloquent
{
    protected $collection = 'fields';
	public $timestamps = false;

	protected $fillable = [
        'scid', 'sport', 'name', 'covering', 'lights', 'surface', 'price' , 'sportname', 'ispublic', 'isreviewed'
    ];

	public static function boot(){

  		parent::boot();
  		
  		Field::observe(new FieldObserver());
		  
  	}
	  
}
