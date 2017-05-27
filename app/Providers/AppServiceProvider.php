<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use View;
use App\Model\Field;
use App\Model\Sportcenter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $field=Field::where('isreviewed', '=', false)
                    ->count();

        $sportcenter=Sportcenter::where('isreviewed', '=', false)
                    ->count();

        $totalpending=$field + $sportcenter;
		
		if($totalpending==0) $totalpending='';
		if($field==0) $field='';
		if($sportcenter==0) $sportcenter='';
	
        View::share('fieldpending', $field);
        View::share('sportcenterpendig', $sportcenter);
        View::share('totalpending', $totalpending);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        require_once __DIR__ . '/../Http/Helpers/Navigation.php';
    }
}
