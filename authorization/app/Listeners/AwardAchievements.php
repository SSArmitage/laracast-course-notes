<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\ProductPurchased;

// event llistener - listens for the product purchased event
class AwardAchievements
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    // using "ProductPurchased" type hinting
    public function handle(ProductPurchased $event)
    {
        // $event class could have a product property such that $event->product
        var_dump('check for new achievements');
    }
}
