<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMe;

class ContactController {
    // this function displays the contact form
    public function show() {
        return view('contact');
    }
    // this function stores the email address & sends an email to that address
    public function store() {
        // validate the request
        // validate method is provided by the Illuminate\Http\Request object. If the validation rules pass, your code will keep executing normally; however, if validation fails, an exception will be thrown and the proper error response will automatically be sent back to the user
        // In the case of a traditional HTTP request, a redirect response will be generated, while a JSON response will be sent for AJAX reques
        // you can pass in a validation rule as a single delimited "|" string OR as arrays of rules
        // i.e. 'required|email' vs ['required', 'email']
        // if the va;idation fails, it will automatically re-direct back to the previous page (without any error info)
        request()->validate([
            'email' => 'required|email'
        ]);
        // can read any form unput by using the request() helper fxn
        // $email = request('email');
        // dd($email);

        // TEXT EMAIL
        // easiest way to send email is via the Mail facade
        // raw() => sends a raw text email
        // 2nd parameter is a closure where you define the paramteres of the message
        // Mail::raw('It works!!!', function($message) {
        //     $message->to(request('email'))
        //     ->subject('Hello there');
        // });

        // HTML EMAIL
        // using the Mail facade still
        // going to send the ContactMe Mailer class that references the html view
        Mail::to(request('email'))->send(new ContactMe("Golden Retrievers"));


        // once the email has been sent, redirect back to the contact page
         // add a flash message via the with() method to the user to indcate the email was sent
        // flash message => data that is put in the session for exactly ONE request
        // so when the user is redirected back to the contact page, a 'message' key will be flashed to the session
        return redirect('/contact')->with('message', 'Email sent!');

    }
}