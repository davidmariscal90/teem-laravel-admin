
composer require jenssegers/mongodb --ignore-platform-reqs

Mail::send([],[], function($message) { $message->to("chintan.adatiya@gmail.com")->subject("Testing email"); });
