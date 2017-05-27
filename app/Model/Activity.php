<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Activity extends Eloquent
{
	 protected $collection = 'activity';

	 public $timestamps = false;

	 protected $fillable = [
        'userid', 'activitydate', 'activitytype', 'onitem', 'onactivityid'
    ];

	public function getActivitydateAttribute($value){
			return date('m-d-Y',($value."")/1000);
	}
}
