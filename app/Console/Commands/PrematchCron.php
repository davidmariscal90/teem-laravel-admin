<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Match;
use App\Model\Team;
use App\Model\Subsport;
use Carbon\Carbon;
use Mail;
use App\Mail\UserMail;
use App\Model\Activity;

class PrematchCron extends Command
{
    protected $signature = 'prematch:cron';
    
    protected $description = 'Prematch cron job run every 3 hour ';
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        // 		adding 3 hours to current time
        
        $now = Carbon::now('UTC');
        $now = new \MongoDB\BSON\UTCDateTime($now->timestamp *1000);

        $timestamp = Carbon::now('UTC')->addHours(3);
        $timestamp = new \MongoDB\BSON\UTCDateTime($timestamp->timestamp *1000);
        
        $matchArray = Match::where('matchtime', '<=', $timestamp)
                                     ->where('isprematch', '=', false)
                                     ->get();
      
        // 		loop for all matches and team
        foreach ($matchArray as $matchId=>$objMatch) {
            $matchid = new \MongoDB\BSON\ObjectID($objMatch['_id']);
            $team = Team::where('matchid', '=', $matchid)
                        ->where('isbenchplayer', '=', false)
                        ->get();
                        
            $teamcount = count($team);
            $teamCountRequired = $objMatch->subsports['value'] * 2;
        
            $spAddress = $objMatch->sportcenter['address'];
            $spName = $objMatch->sportcenter['name'];

            // echo "\nTeamCount: ",$teamcount;print_r($team);echo "\n";
            // exit();

            foreach ($team as $teamkey=>$teamObj) {
                if ($teamcount == $teamCountRequired) {
                    Mail::to($teamObj->user['email'])->queue(new UserMail($teamObj->user, $objMatch, 'prematchsuccess'));
                    //Mail::to('ankurgarach@logisticinfotech.co.in')->queue(new UserMail($teamObj->user,$objMatch,'prematchsuccess'));
                } else {
                    echo "\nCancel Email to: ",$teamObj->user['email'];
                    //Mail::to('ankurgarach@logisticinfotech.co.in')->queue(new UserMail($teamObj->user,$objMatch,'prematchcancel'));
                    //Mail::to($teamObj->user['email'])->queue(new UserMail($teamObj->user, $objMatch, 'prematchcancel'));
                    Mail::to($teamObj->user['email'])->queue(new UserMail($teamObj->user, $objMatch, 'prematchcancel'));
                }
            }
            //exit();
            if ($teamcount == $teamCountRequired) {
                $objMatch->isprematch=true;
                $objMatch->save();
            } else {
                $objMatch->isprematch=true;
                $objMatch->iscancelmatch=true;
                $objMatch->save();

                $userid=new \MongoDB\BSON\ObjectID($objMatch['userid']);

                $actArr=array();
                $actArr['userid']=$userid;
                $actArr['activitydate']=$now;
                $actArr['activitytype']='canceled';
                $actArr['onitem']='match';
                $actArr['onactivityid']=$objMatch['_id'];
                
                Activity::create($actArr);
            }
        }

        $matchComplete = Match::where('matchtime', '<=', $now)
								->where('iscancelmatch','=',false)
								->where('iscompletedmatch','=',false)
								->where('isprematch', '=', true)
								->get();

		//print_r($matchComplete);
      
        if (count($matchComplete)>0) {
            foreach ($matchComplete as $matchCompKey=>$matchComObj) {
                $userid=new \MongoDB\BSON\ObjectID($matchComObj['userid']);

                $activityArr=array();
                $activityArr['userid']=$userid;
                $activityArr['activitydate']=$now;
                $activityArr['activitytype']='completed';
                $activityArr['onitem']='match';
                $activityArr['onactivityid']=$matchComObj['_id'];
                
                $activity=Activity::create($activityArr);

				if($activity){
					$matchComObj->iscompletedmatch=true;
					$matchComObj->save();
				}
            }
        }
    }
}
