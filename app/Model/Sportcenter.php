<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Sportcenter extends Eloquent
{
    protected $collection = 'sportcenter';
	public $timestamps = false;

}
