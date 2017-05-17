<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserMail extends Mailable
{
    use Queueable, SerializesModels;
   
    public $user,$match,$type, $subj;
    public function __construct($user,$match,$type)
    {
        $this->user=$user;
        $this->match=$match;
        if($type=="prematchsuccess") {
            $this->type=$type;
			$this->subj = "Match Scheduled Notification";
		}
        else if($type=="prematchcancel") {
            $this->type=$type;
			$this->subj = "Match Canceled Notification";
		}
    }   

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //file_put_contents('/var/www/html/TeemLaravel/readme.txt',$this->match->sportcenter['name'],FILE_APPEND);
        return $this->view('emails.'.$this->type)
				->subject($this->subj)
                ->with(['username' => $this->user['username']])
                ->with(['matchname' => $this->match->sportcenter['name']])
                ->with(['matchaddress' => $this->match->sportcenter['address']]);
    }
}
