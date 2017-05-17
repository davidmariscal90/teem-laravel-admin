<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class User extends Eloquent
{

	protected $collection = 'user';
	public $timestamps = false;
	protected $fillable =['username','email','profileimage','profilethumbimage','isactive','passwordresettoken',
	        'activationlink','dob','city','description','sports','encryptedpassword','activateddate','firstname','lastname'
	     ];
	
 	protected $hidden = ['encryptedpassword'];	
    protected $dates = ['activateddate'];

	public function getActivateddateAttribute($value){
			return date('m-d-Y', strtotime($value));
	}
	
}
