<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Model\Match;
use App\Model\Team;
use App\Model\Subsport;
use Carbon\Carbon;
use Mail;
use App\Mail\UserMail;

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
        $timestamp = Carbon::now('UTC')->addHours(3);
        $timestamp = new \MongoDB\BSON\UTCDateTime($timestamp->timestamp *1000);
        
        $matchArray = Match::where('matchtime', '<=', $timestamp)
                                     ->where('isprematch', '=', false)
                                     ->get();
        
        // echo "\n";print_r($matchArray);echo "\n";
        // exit();

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
            }
        }
    }
}
