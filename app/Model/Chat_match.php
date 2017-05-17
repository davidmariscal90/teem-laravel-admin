<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Chat_match extends Eloquent
{
    protected $collection = 'chat_match';
	public $timestamps = false;
}
