<?php 
namespace App\Observers;

use App\Model\Sportcenter;

use App\Model\Field;

use App\Model\Match;

use App\Model\Team;

use App\Model\Invitation;

use App\Model\Chat_match;

class SportcenterObserver
{
    public function created(Sportcenter $sportcenter)
    {
    }

    public function creating(Sportcenter $sportcenter)
    {
    }
    
    public function updating(Sportcenter $sportcenter)
    {
    }

    public function updated(Sportcenter $sportcenter)
    {
    }

    public function saved(Sportcenter $sportcenter)
    {
    }

    public function saving(Sportcenter $sportcenter)
    {
    }

    public function deleting(Sportcenter $sportcenter)
    {
		//file_put_contents('/var/www/html/TeemLaravel/readme.txt',$field,FILE_APPEND);
		
		$scId=new \MongoDB\BSON\ObjectID($sportcenter['_id']);
		
		Field::where('scid','=',$scId)
					->delete();

		$match=Match::where('scid','=',$scId)
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

    public function deleted(Sportcenter $sportcenter)
    {
    }

    public function restoring(Sportcenter $sportcenter)
    {
    }

    public function restored(Sportcenter $sportcenter)
    {
    }
}
