# About this lesson (6 lessons)

## ***** CORE CONCEPTS *****
### 1. Collections
Our first core concept is collection chaining. As you've surely learned by now, when fetching multiple records from a database, a Collection instance is returned. Not only does this object serve as a wrapper around your result set, but it also provides dozens upon dozens of useful manipulation methods that you'll reach for in every project you build.
NOTES:
- definition of Collection class found in vendor/laravel/framework/src/illuminate/Database/Eloquent/Collection.php
- use model class to query database table 
- i.e. App\Article::first() => returns one article
- i.e. App\Article::all() => returns all articles (as a collection of articles => [])
- can call methods on these collections, some of which sound like a SQL queries, but is just a similar API (not performing SQL query to the databse, but performing method on the results returned from the database -  the collection instance)
- i.e. App\Article::all()->where('name', 'php')
- the first() method can take a callback fxn as an argument
    i.e. App\Article::all()->first(function($article) {
        return strlen($article->title) > 8;
    })
    => this will only return the first article in the collection where the closure returns true (has a title longer than 8 characters)
- you can also create your own collection
    i.e. collect(['one', 'two', 'three']);
    => you can call the same methods on these as well
    i.e. collect(['one', 'two', 'three'])->first();
- the flatten() method converts a nested array into a single-dimension
    i.e. collect(['one', 'two', 'three', ['four', 'five'], 'six'])->flatten*();
    returns => ['one', 'two', 'three', 'four', 'five', 'six']
- useful methods => filter, map, flatMap, where, merge
- the filter() method allows you to filter a collection down to a subset (not destructive though, d/n alter the original collection, which means in order to save the returned results, you need to assign it to a variable)
    i.e. filter items to only include those >= 5
    $items = collect([1, 2, 3, 4, 5, 6]);
    $greaterThan4 = $items->filter(function($item) {
        return $item >= 5;
    });
    i.e. filter items to only include those divisible by 2 (use modulus operator %)
    $items = collect([1, 2, 3, 4, 5, 6]);
    $divisibleBy2 = $items->filter(function($item) {
        return $item % 2 === 0;
    });
- all these methods return collections, so that means they are chainable
    i.e. map over the filtered items and return each item * 3
    $items = collect([1, 2, 3, 4, 5, 6]);
    $divisibleBy2 = $items->filter(function($item) {
        return $item % 2 === 0;
    })->map(function($item) {
        return $item * 3;
    });
- eager loading (technique) => what if you want to group articles based on their "tag" category (but the articles dont come with a "tag" property) => here we eager load the tags relationship (give me all the articles with their associated tags) => the string passed into with('') corresponds to the model method, i.e. with('tags') means App\Article's tags() method!
    i.e. App\Article::with('tags')->get();
    This will return the articles as:
    App\Article {#4025
         id: 1,
         user_id: 1,
         title: "Article Title #1",
         excerpt: "My first article",
         body: "Aut natus sequi quia non harum alias provident vel. Nihil illum excepturi in quod recusandae. Voluptas ipsa in neque officiis rerum eum.",
         created_at: "2020-07-27 01:15:15",
         updated_at: "2020-07-27 01:15:15",
         tags: Illuminate\Database\Eloquent\Collection {#4048
           all: [
             App\Tag {#4057
               id: 1,
               name: "php",
               created_at: "2020-07-27 15:40:07",
               updated_at: "2020-07-27 15:40:07",
               pivot: Illuminate\Database\Eloquent\Relations\Pivot {#4056
                 article_id: 1,
                 tag_id: 1,
                 created_at: null,
                 updated_at: null,
               },
             },
           ],
         },
       }
- if we are displaying a current article, and we want to display all of its tags, need to pluck out all the tag names
    i.e. $articles = App\Article::all();
    => the following will return all the tags associated with each article in the form of as collection (so an array of collection arrays)
    $articles->pluck('tags');
    => the following will collapses the collection of arrays into a single, flat collection
    $articles->pluck('tags')->collapse();
    => the followign will grab the name from each Tag element (there will be dupliates because articles can have the same tag)
    $articles->pluck('tags')->collapse()->pluck('name');
    => the following will grab one of each element (removes duplicates)
    $articles->pluck('tags')->collapse()->pluck('name')->unique();

### 2. CSRF Attacks
Laravel provides Cross-Site Request Forgery (CSRF) protection out of the box, but you still may not know exactly what that means. In this lesson, I'll show you a few examples of how a CSRF attack is executed, as well as how Laravel protects your application against them.
FILES WORKED WITH:
- Kernel.php
NOTES:
- CSRF is also known as one-click attack or session riding
- CSRF exploits the trust that a site has in a user's browser
- a type of malicious exploit of a website where unauthorized commands are submitted from a user that the web application trusts.
- In a CSRF attack, an innocent end user is tricked by an attacker into submitting a web request that they did not intend. This may cause actions to be performed on the website that can include inadvertent client or server data leakage, change of session state, or manipulation of an end user's account
- a different application takes advantage of the your broswer's knowledge of the current state and what's in your session
CSRF EXAMPLES:
-  assuming the attacker knows something about the endpoints of an application => certain endpoints update a user, or log out a user, etc
    1. if they embed a broken url in an image tag, it will immediately hit the url when they load the page
    <!-- <img src="http://targetSitName.test/logout"> -->
    => makes a GET request to the /logout endpoint (more likely this endpoint will be a POST)
    => this logout interaction in one site can affect another site, i.e. it will log out the target user
    2. if they include a button that does something i.e. in the welcome view 
    <!-- <form method="POST" action="http://targetSitName.test/logout">
            <button>Continue</button>
        </form> -->
    => makes a POST request to the /logout endpoint
    => redirects to the target but gives a 419 error (d/n log out the user in this case - laraval security)
    => laravel is protecting you without you even knowing it!
    => 419 error => go look in the Response.php class to see the different status codes, but 419 is not in there => laravel uses 419 to represent a failed CSRF verification
    => to see hoe the failed verification is happening: go to app/Http/Kernel.php, in the $middlewareGroups method there is a 'web' property that contains all the middleware the runs when a request is performed. This includes a "VerifyCsrfToken" class => this class has a handle() method that checks if the tokens match, so its trying to fetch a token from the request that was made, and then its comparing it against a token in the session that laravel creates automatically. If those do not match, its going to throw a "TokenMistmatchException", and ultimately thats converted to a 419
    => checking to see if the request is coming from the athenticated user
    3. making a ajax request behind the scenes without you knowing

- @csrf blade directive (placed within the form) => helper function that expands to a hidden input
<!-- <input type="hidden" name="_token" value="uniqueCharacters"> -->
- the input value is equal to the token from the session
- when you submit the form, this token is included as part of the request, so when it hits your server, that "VerifyCsrfToken" middleware is going to perform a match
* you have your own VerifyCsrfToken.php middleware in app/Http/Middleware/VerifyCsrfToken.php, but this just extends the previous one Illuminate\Foundation\Http\Middleware\VerifyCsrfToken => this is where you can control exceptions (instances when you dont want automatic CSRF protection i.e. "stripe" webhooks) => you would include it in the $except method
TAKEAWAY: whenever you create a form that will submit a POST, PUT, or UPDATE request, make it a habit to always include the "@csrf" directive

### 3. Service Container Fundamentals
Laravel's service container is one of the core pillars of the entire framework. Before we review the real implementation, let's first take a few moments to build a simple service container from scratch. This will give you an instant understanding of what happens under the hood when you bind and resolve keys.
FILES WORKED WITH:
- Container.php
- web.php
- Example.php

### 4. Automatically Resolve Dependencies
Now that you understand the basics of a service container, let's switch over to Laravel's implementation. As you'll see, in addition to the basics, it can also, in some cases, automatically construct objects for you. This means you can "ask" for what you need, and Laravel will do its best - using PHP's reflection API - to read the dependency graph and construct what you need!
FILES WORKED WITH:
- Container.php
- web.php
- Example.php
- Collaborator.php
- services.php
NOTES:
- Laravel's service container is the "app" itself
    i.e. app()->bind('example', function() {
        return new App\Example;
    })
    => this binds a anew key "example" in the "app" service container
    => to retrieve this "example" class instance, there is a resolve() helper fxn
    i.e. Route::get('/', function() {
        $example = resolve('example');
    })
    => a lot of the time you will require a bunch of things to build out an instance such as $example, like a config file or service in services.php that holds a special key. For example you could need a certain key from services.php to instantiate the Example class (read the config and find all the necessary paraemters to construct this object, declare whats needed one time)
     i.e. app()->bind('example', function() {
        - fetch the "foo" setting (config setting you need) and pass to the class to be instantiated
        - config() => reads any of the config files by providing the file name along with the key name => "services.foo"
        $foo = config('services.foo');
        return new App\Example($foo);
    })
    => NOW, remove the app()->bind(), and in the '/' route closure, swap the "key" ("example") for the path to the Example class
    i.e. Route::get('/', function() {
        - here we are EXPLICITLY resolving Example out of the container
        $example = resolve(App\Example::class);
        dd($example);
    })
    => in this case, you have not bond anything to the app container, yet it will still work like the above did...
    => remove the $foo dependancy
    => and add a Collaborator (represent any dependancy the Example class has) - place with the other class files in app
    i.e. app/Collaborator.php
    => add the Collaborator parameter as a dependancy in the Example constructor
    => now, when we request an instance, we told laravel that we wanted an instance of Example, so laravel looked into its service container and checked if it has anything for this key (what gets passed into the resolve() helepr fxn) in the container, but there is nothing in there. Next it checks if whats passed into resolve() is an existing class (are you trying to resolve an existing class?), and yes there is an Example class, so laravel assumes thats what you want, and it instantiates Example. Then during instantiation, it reads the constructor arguments, and it comes across the Collaborator, so it knows that in order for this object to be created it needs a Collaborator, so it then looks at the Collaborator class and checks if that can be instantiated, if it can laravel instantite it and passes it in the Example constructor automatically (laravel continues this process for every argument -  is this something I can create?)
    => you can also IMPLICTLY resolve the Example class out of the container (also known as AUTOMATIC RESOLUTION - if it can, laravel will automatically pass in what we need)
    i.e. Route::get('/', function(App\Example $example) {
            ddd($example);
    })
    => this will still work! Due to the power of laravel's app service container (works the same if using a route closure or a dedictaed controller + action)
    i.e. Route::get('/', 'PagesController@home');
    class PagesController {
        public function home(App\Example $example) {
            ddd($example);
        }
    }
    => if the Example class also requires a dependancy called $extra, but laravel cant find it (no type associated with it - laravel d/n know if $example is a string, a number, etc...), you will get an exception (BidingResolutionException), laravel is saying "I'm trying to resolve this out of the container for you, but I dont know how, and you havent instructed me how!" => situations like this, you need to be EXPLICIT! => you would include an app()->bind() that explititly defines the "extra" key and binds it to the container
    i.e. app()->bind(App\Example, function() {
        - being EEXPLICIT about how to create the $example instance
        $collaborator = new App\Collaborator;
        $extra = 'someValue'
        return new App\Example($collaborator, $extra);
    })
    => this logic would be included in a "service provider" => laravel includes an AppServiceProvider out of the box, where you register any services in the service container 
    i.e. class AppServiceProvider {
        public function regitser() {
            app()->bind(App\Example, function() {
                - being EEXPLICIT about how to create the $example instance
                $collaborator = new App\Collaborator;
                $extra = 'someValue'
                return new App\Example($collaborator, $extra);
            })
        }
    }
    => inside any provider class you have access to an "app" property - so you d/n need to create an application instance app()
    i.e. $this->app->bind() 
    => sometimes when you resolve something out of the container, you d/n want a new instance every time, you want the same one => in this case you would use "singleton" => no matter how many times you resolve App\Example, you will get the exact same Example instance (has the same object #). If you just used bind() it would construct a new object each time
    i.e. $this->app->singleton()

### 5. Laravel Facades
Now that you have a basic understanding of the service container, we can finally move on to Laravel facades, which provide a convenient static interface to all of the framework's underlying components. In this lesson, we'll review the basic structure, how to track down the underlying class, and when you might choose not to use them. 
FILES WORKED WITH:
- web.php
- PagesController.php
- vendor\laravel\framework\src\Illuminate\Support\Facades\View.php
- vendor\laravel\framework\src\Illuminate\Support\Facades\Request.php
- vendor\laravel\framework\src\Illuminate\View\Factory.php
NOTES:
- any file in the vendor directory is pulled in using composer
- theres a bunch of facades included with the framework (most of the framework is accessible through facades)
- facades provide a static interface to underlying components in the framework (a convenience that you can reference without having to manually build up objects and their dependancy chains)
- every facade has a bunch of static methods available to it (these static mehods arent on the facade itself, but on an underlying class that is referenced in the facade - @see directive in the facade file)
- the facade isnt doing the work, its only job is to proxy your calls to the underlying class!
- every facade has a getFacadeAccessor() method, it returns a key that references a binding in the app service container 
    i.e. in the Request facade, 'request' is returned by the getFacadeAccessor() method, so the binding in the service contaner is called 'request'
    => when you resolve('request') from the service container, it returns an instance of a class (Illuminate\Http\Request), and this is the class that has the input() method on it => so behind the scences Request must resolve the "request" key out of the service container, returning this Illuminate\Http\Request instance, and then you call input() method on this object
    => the "@see \Illuminate\View\Factory" inside of the Request facade refers you to the underlying class 
    i.e. Request::input('foo') => input() is a static method that proxies to an underlying class (Illuminate\Http\Request), and this class has the input() method on it 
- if you know the underlying class, you can "inject it"
    i.e. where File is the facade & Filesystem is the underlying class
    instead of this:
    class PagesController extends Controller {
        public function home() {
            return File::get(public_path('index.php'));
        }
    }
    Do this:
    class PagesController extends Controller {
        <!-- ask for an instance of filesystem as $file, laravel will read this and automatically resolve this and pass in the correct argument  -->
        <!-- not using the File facade anymore, but its the exact same method being called -->
        public function home(Filesystem $file) {
            return $file->get(public_path('index.php'));
        }
    }
    => BUT! Using the Facade approach, you dont have to inject the underlying class into the constructor and instantiate the object on the fly
    => the result is a slightly more expressive syntax
    => and there are Facades for most of the framework
- WARNING => a benefit of defining all of a classes dependancies within the constructor is that it makes it instantly clear what is required in order for this class to function, so when you instead have these laravel facades it blurs things a bit and its harder to tell when there are too many dependancies in your constructor and when you should abstract a different class or collaborator
- TAKEAWAY => Facades are useful and convenient to use sometimes

*** tech challenge ***
- read a file i.e. uploaded csv file
- use the file system class or the File facade
- the helper fxn public_path() => path of the public directory
- get() => get the contents of a file
    i.e. File::get(publi_path('index.php'))
    => go into the public directory and read index.php

### 6. Service Providers
We've spent the last two episodes reviewing Laravel's service container and facades. All of that work is about to pay off, as we move on to service providers. A service provider is a location to register bindings into the container and to configure your application in general.
FILES WORKED WITH:
- FilesystemServiceProvider.php
- config/app.php
- Example.php
- ExampleFacade.php
- AppServiceProvider.php
NOTES:
- the "vendor" directory is where dependencies pulled in through composer are installed
- the laravel framework itself is pulled in through composer
    => the framework is divided into components, and each component directory includes a service provider
    i.e. the Filesystem component has the FilesystemServiceProvider.php
- service providers provide a service to the framework i.e. register keys to the service container, or trigger some functionality after the framework has been booted
    => service providers have two methods: register() and boot()
    => register() => registers keys to the service container
        i.e. public function register() {
            $this->registerNativeFileSystem();
        }
        public function registerNativeFileSystem() {
            <!-- registering this key called 'files' into the container, it is a singleton, which means there should only ever be ONE instance of it, and if you resolve it, you will recieve a new instance of this Filesystem class -->
            $this->app->singleton('files', function() {
                return new Filesystem
            })
        }
    => boot() => this method is triggered after every service provider in the framework has been registered
    => so first the framework loops over all of its providers to be loaded as part of the framework (list of these found in config/app.php in the 'providers' property), and for each one it will call a register() method (each of these providers will register themselves with the framework), it will them loop over a second time and will call the boot() method on each provider, this would trigger some sort of functionality after the framework has been registered
- so the key is registered into the container by the service provider, and the facade resolves that key out of the container (returning a class instance)
- you can create your own facade (that will proxy to some underlying class)
    => add a hanlde() method to Example.php
    => create an ExampleFacade.php that returns the key 'example'
    => go into the AppServiceProvider.php thats included in the app, and register the key 'example' into the container with the value that will be returned when the key is resolved
    => so the key is now bound to the container and it returns the Example class instance
    => So now when you call App\ExampleFacade::hanlde(), it will return the key 'example', resolve that key out of the service container and return an instance of the Example class, then the hanlde() method will be called on the Example insatnce and that method will run (essentially the facade will proxy to the hanlde() method in Example.php)
- normally there will be lots of registration needed to instantiate the Example class (dependencies declared in the constructor & passed into Example where it is being bound to the container -  in the AppServiceProvider register() method) i.e. config settigs, api keys
    => storing this in the service container means you only need to delcare this info once
    => so when you need to grab the Example class with its dependencies, you only have to reference the key in the container 
- REMINDER: when laravel tries to resolve something out of the container, it first checks if what you have passed in as the key is bound to your container, if not, it then checks if what you passed is a class, if it is, it will then try to construct that object for you automatically (checking if it has all the arguments needed to construct the object)