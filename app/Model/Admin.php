<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model as Moloquent;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
        use Notifiable;
     protected $collection = 'admin';

     protected $fillable = [
        'name', 'email', 'password',
    ];

}
