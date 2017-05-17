
Replace this in User.php in Foundation

use Jenssegers\Mongodb\Eloquent\Model as Model;

composer require jenssegers/mongodb --ignore-platform-reqs

Mail::send([],[], function($message) { $message->to("chintan.adatiya@gmail.com")->subject("Testing email"); });
