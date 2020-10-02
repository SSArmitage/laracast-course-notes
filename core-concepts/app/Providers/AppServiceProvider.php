<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Example;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // bind the key 'example' into the container, and if you resolve it, return new instance of the Example class
        // if the construction of the Example class has dependencies you would pass them into the new instance here i.e. return new Example('api-key')
        $this->app->bind('example', function() {
            return new Example();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
