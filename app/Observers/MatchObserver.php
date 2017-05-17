<?php 
namespace App\Observers;

use App\Model\Match;

use App\Model\Team;

use App\Model\Invitation;

use App\Model\Chat_match;

class MatchObserver
{
    public function created(Match $match)
    {
    }

    public function creating(Match $match)
    {
    }
    
    public function updating(Match $match)
    {
    }

    public function updated(Match $match)
    {
    }

    public function saved(Match $match)
    {
    }

    public function saving(Match $match)
    {
    }

    public function deleting(Match $match)
    {
		$matchId=new \MongoDB\BSON\ObjectID($match['_id']);
			
		Team::where("matchid","=",$matchId)
			->delete();
	
		Invitation::where("matchid","=",$matchId)
			->delete();
	
		Chat_match::where("matchid","=",$matchId)
			->delete();
    }

    public function deleted(Match $match)
    {
    }

    public function restoring(Match $match)
    {
    }

    public function restored(Match $match)
    {
    }
}
