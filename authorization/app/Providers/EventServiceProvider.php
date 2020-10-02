<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\ProductPurchased;
use App\Listeners\AwardAchievements;
use App\Listeners\SendShareableCoupon;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        // when a product is purchased, then trigger these listeners...
        ProductPurchased::class => [
            AwardAchievements::class,
            SendShareableCoupon::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    public function shouldDiscoverEvents()
    {
        // this is false but default (vendor\laravel\framework\src\Illuminate\Foundation\Support\Providers\EventServiceProvider.php)
        // if you turn it on, laravel will automatically scan the Listeners directory, and it will read the classes in the directory (using php's reflection API), and looks for a handle() method along with an event (now has the listener class + has the associated event class), and it will automatically build up that listeners array for you
        return true;
    }

    
}
