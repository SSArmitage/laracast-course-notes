<?php

namespace App;

use Illuminate\Support\Facades\Facade;

class ExampleFacade extends Facade {
    // override getFacadeAccessor() method
    protected static function getFacadeAccessor() {
        // somewhere behind the scenes this ExampleFacade will resolve the ('example') key out of the service container
        // so whatever is returned here is passed to resolve() => meaning you could also pass in the class itself instead of the key (both are strings)
        // you would do this (return the Example instance) if the facade was simply proxying to another class (nothing bound in the container)
        // return Example::class => 'App\Example'
        return 'example';
    }
}