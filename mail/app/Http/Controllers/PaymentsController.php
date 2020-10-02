<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PaymentRecieved;

class PaymentsController {
    public function create() {
        return view('payments.create');
    }

    public function store() {
        // use the Notification facade
        // send() => 1st parameter is the recipiient of the notification, the 2nd parameter is what notification to send (here we are istantiating a new PaymentRecieved class - which extends the Notification class)
        // send a notification to the user that is currently signed in
        // in real life, will have a payment object, or model, or something else that you would pass into the PaymentRecieved(), here hardcoding the payment recieved in cents
        Notification::send(request()->user(), new PaymentRecieved(900));
        // instead of the above, you can also write:
        // the User class has a notify() metod available
        // request()->user()->notify(new PaymentRecieved());
        // or if you already have a $user variable
        // $user->notify(new PaymentRecieved());
    }
}