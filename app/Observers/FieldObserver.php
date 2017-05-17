<?php 
namespace App\Observers;

use App\Model\Field;

use App\Model\Match;

use App\Model\Team;

use App\Model\Invitation;

use App\Model\Chat_match;

class FieldObserver
{
    public function created(Field $field)
    {
    }

    public function creating(Field $field)
    {
    }
    
    public function updating(Field $field)
    {
    }

    public function updated(Field $field)
    {
    }

    public function saved(Field $field)
    {
    }

    public function saving(Field $field)
    {
    }

    public function deleting(Field $field)
    {
		//file_put_contents('/var/www/html/TeemLaravel/readme.txt',$field,FILE_APPEND);
		
		$fieldId=new \MongoDB\BSON\ObjectID($field['_id']);
		
		$match=Match::where('fieldid','=',$fieldId)
					->get();

		if(count($match)>0){
						
				foreach($match as $matchKey=>$matchObj){		
				
					$matchId=new \MongoDB\BSON\ObjectID($matchObj['_id']);
			
					Team::where("matchid","=",$matchId)
						->delete();
				
					Invitation::where("matchid","=",$matchId)
						->delete();
				
					Chat_match::where("matchid","=",$matchId)
						->delete();
			
					$matchObj->delete();
			
				}
		}
    }

    public function deleted(Field $field)
    {
    }

    public function restoring(Field $field)
    {
    }

    public function restored(Field $field)
    {
    }
}
