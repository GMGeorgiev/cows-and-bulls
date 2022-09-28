<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['validator']->extend('dupes', function ($attribute, $value, $parameters)
        {
            $valueArr = str_split($value);
            if(count(array_unique($valueArr))<count($valueArr)){
                return false;
            }
            return true;
        });
    }
}
