<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Sports extends Eloquent
{
    protected $collection = 'sport';
	public $timestamps = false;
    protected $fillable =['title','imageurl'];
    
}
