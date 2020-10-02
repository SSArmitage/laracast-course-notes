<?php

namespace App\Http\Controllers;
// import the facade
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Request;

class PagesController extends Controller {
    public function home() {
        // *** REQUEST FACADE ***
        // grab the name property off the request object and return its value
        // 1. request()
        // return request('name');
        // 2. Request::input()
        return Request::input('name');


        // *** VIEW FACADE ***
        // 1. view()
        // return view('welcome');
        // can also use a "view facade" render a view (functionally identical to the above)
        // behind the scenes a view factory is being refernced 
        // the static "make" method is not on the View itself, but on the factory class (Factory.php) => the factory gets the view contents for the given view (you don't have to instantiate the factory, or bring in all the dependencies that this object requires, it does it for you)
        // 2. View::make()
        // return View::make('welcome');
    }

}