<?php

namespace App;

class Example {

    protected $collaborator;

    protected $extra;

    // protected $foo;

    // constructor
    // require this $foo key to instantiate the class => get the key from the services.php (read the config and find all the necessary paraemters to construct this object, declare whats needed one time)
    // public function _construct($foo) {
    //     $this->foo = $foo;
    // }

    // tell the constructor that construction of the Example class instance requires the Collaborator class as a dependancy
    // it could also require $extra as a dependancy
    public function _construct(Collaborator $collaborator, $extra) {
        $this->collaborator = $collaborator;
        $this->extra = $extra;
    }


    public function go() {
        dump('it works!');
    }

    public function handle() {
        die('it works!');
    }
}