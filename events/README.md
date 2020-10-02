# About this lesson (1 lesson)

## ***** EVENTING *****
### 1. Eventing Pros & Cons
Events offer a way for one part of your application to make an announcement that ripples through the entire system. In this episode, we'll not only review the essentials, but we'll also discuss the pros and cons to this particular approach to structuring an application.
FILES WORKED WITH:
- PaymentsController.php
- EventServiceProvider.php
- Events\ProductPurchased.php
- Listeners\AwardAchievements.php
- Listeners\SendShareableCoupons.php
NOTES:
- php artisan has a bunch of "event" commands
    i.e. "php artisan event:list" will show you all the events and their associated listeners in the application
- events & listeners (IF the event occurs, THEN trigger this listener)
- events => an action that just took place in your system 
    => i.e. a product was just purchased
    => payment is an "event" in the application
        => CORE LOGIC that must take place as part of this request:
        1. process the payment (using some billing provider i.e. Stripe)
        2. unlock the purchase (i.e. by generating a liscence code)
        => ADDITIONAL LOGIC (side effects that need to also occur):
        * each of the following are their own classes that listen for an event and respond (listeners)
        1. notify the user (i.e. send email, sms message) telling them the payment has been processed
        2. award achievements (i.e. every 6th purchase the user gets a new acheivement)
        3. stay engaged with the user, i.e. schedule an email for 2 days after the purchase, could include a sharable coupon ("we hope you're enjoying the product, if you are, here's 20% off  to share with a friend")
- the EventServiceProvider class is the bootstrap for everything "event" related in you applciation
    => has a map (array) that defines all events (keys) and listeners (values)
    => here you will connect all your events and listeners
- create a new event, run "php artisan make:event ProductPurchased"
    => the new event will have a broadcastOn() method. Broadcasting (a class) functionality => if you need a server-side event to be boraadcasted to the client-side, so that it can be picked up by your JavaScript (won't always need this functionality)
- dispatch the event (2 ways to do it)
    1. call a static function dispatched() on the ProductPurchased class, pass in the product as an argument (will usually be a product model, in this case we hard code the product as 'toy')
        ProductPurchased::dispatch('toy');
        => ProductPurchased has a "Dispatchable" trait
        => Dispatchable has a public static function dispatch()
        => allows you to call dispatch() on the ProductPurchased class
        => dispatch() delegates to the event() helper function
    2. use event() helper function pass in a new instance of the ProductPurchased class
        event(new ProductPurchased('toy'));
- create the listeners, run "php artisan make:listener AwardAchievements -e ProductPurchased"
    => includes the event class name to autofill when the file is created
- now you need to connect the event and the listener
    => in the EventServiceProvider class, register a new listener in the $listen array
    => laravel can handle this connection for you! Inside EventServiceProvider, you can add/overwrite a method called shouldDiscoverEvents() => set it to true
        => if you turn it on (true), laravel will automatically scan the Listeners directory, and it will read the classes in the directory (using php's reflection API), and looks for a handle() method along with an event (now has the listener class + has the associated event class), and it will automatically build up that listeners array for you
        => this approach makes it easier to add new listeners
- * if you need to see what is happening in response to an event:
    => run "php artisan event:list" to see all the events and their associated listeners in the application
    => search "handle(ProductPurchased $event)" to see all the files where the ProductPurchased event is being handled
 