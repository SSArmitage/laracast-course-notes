<?php

namespace App;

// THIS IS A DEMO CLASS - JUST BUILT FOR PRACTICE
// service container => a container for services (to store & retrieve)
// service => any kind of data, i.e. string, number, object, collection, etc
class Container {

    protected $bindings = [];

    // this function will bind a key/value pair to the container by adding it to the $bindings array
    public function bind($key, $value) {
        $this->bindings[$key] = $value; 
    }

    // this function grabs the value of a given key from the container
    public function resolve($key) {
        
        if (isset($this->bindings[$key])) {
            // can call the method by adding () at the end
            return $this->bindings[$key]();
            // can also call this method using the following:
            // call_user_func() => calls the callback function passed in 
            // return call_user_func($this->bindings[$key])
        }
    }
}