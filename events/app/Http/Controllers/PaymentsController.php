<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentRecieved;
use App\Events\ProductPurchased;

class PaymentsController {
    public function create() {
        return view('payments.create');
    }

    public function store() {
        // payment is an "event" in the application
        // CORE LOGIC that must take place as part of this request:
        // 1. process the payment (using some billing provider i.e. Stripe)
        // 2. unlock the purchase (i.e. by generating a liscence code)
        // dispatch the payment event (2 ways to do it - both do the accomplish the exact same thing)
        // 1. call a static function dispatched() on the ProductPurchased class
        // will pass in the product (will usually be a product model, in this case we hard code 'toy')
        ProductPurchased::dispatch('toy');
        // 2. use event() helper function pass in a new instance of the ProductPurchased class
        event(new ProductPurchased('toy'));

        // ADDITIONAL LOGIC (side effects that need to also occur):
        // * each of the following are their own classes that listen for an event and respond
        // 1. notify the user (i.e. send email, sms message) telling them the payment has been processed
        // 2. award achievements (i.e. every 6th purchase the user gets a new acheivement)
        // 3. stay engaged with the user, i.e. schedule an email for 2 days after the purchase, could include a sharable coupon ("we hope you're enjoying the product, if you are, here's 20% off  to share with a friend")
    }
}