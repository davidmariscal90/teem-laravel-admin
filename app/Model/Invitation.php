<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;

class Invitation extends Moloquent
{
    protected $collection = 'invitation';
    protected $fillable = ['matchid','inviterid','userid','accepted'];
}
