<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MenuCatalogue;
use View;
use App\Models\SubCatalogue;
use Session;
use App\Utilities\Cart;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $cats = MenuCatalogue::with('subcatalogues')->get();

        view()->composer('*',function($view) use  ($cats){
            $view->with('global',array('name'=>"koun",'cats'=>$cats));
        });


    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
