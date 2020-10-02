## Final Project (10 Lectures)

### 1. Twitter Clone Setup
You've reached the final project for "Laravel From Scratch." Great job making it this far! To put your skills to the test, our final task is to build a Twitter clone, called "Tweety." We'll need to build the design, and add the necessary functionality to login, follow friends, view a timeline, and favorite posts that we like.
In this episode, we begin with the initial project setup.
FILES WORKED WITH:
- .env
- webpack.mix.js
- resources/css/main.css
- app.blade.php
- welcome.blade.php
NOTES:
- create base file (with authentication out of the box)
    => run "laravel new tweety --auth"
- configure database
    => go into .env file and change the database name
    => run "php artisan migrate"
- bring in a css framework (tailwind)
    => run "npm install tailwindcss"
    => do Laravel Mix setup (setting up Tailwind with common build tools i.e Laravel Mix)
        => go into webpack.mix.js file
        => paste the following into that file:
            mix.postCss('resources/css/main.css', 'public/css', [
            require('tailwindcss'),
            ])
        => tells Laravel mix to compile the css (from tailwind plugin?)
    => in the resources directory add a css folder and inside create a main.css file
    => add tailwind to your css
        => Use the @tailwind directive to inject Tailwind's base, components, and utilities styles into your CSS
        => Tailwind will swap these directives out at build time with all of its generated CSS
        => paste the following into the main.css file
            @tailwind base;
            @tailwind components;
            @tailwind utilities;
- install the rest of your dependencies
    => run "npm install"
- compile everything down
    => run "npm run dev"
    => should alert "build succcessful"
    => to check, go into public/css/main.css and you should see all of the tailwind specific code
- go into views/layout/app.blade.php file and import tailwind
    => remove the bootstrap scaffolding provided by laravel
        => delete the public/css/app.css file
        => in app.blade.php, change the styles link to main.css
- go into welcome.blade.php, go to the div with class "content" and change the app title to "Tweety," and remove unecessary code

### 2. Design the Timeline
Before we can dive into writing the core logic, let's first set aside fifteen minutes or so to design the main timeline page, using Tailwind.
FILES WORKED WITH:
- home.blade.php
- app.blade.php
NOTES:
- 

### 3. Make the Timeline Dynamic
Now that we have a nice - but static - layout in place, we can begin making the different sections dynamic. We'll begin with the core of our application: tweets!
View the source code for this episode on GitHub.
FILES WORKED WITH:
- database/migrations/...create_tweets_table.php
- database/factories/TweetFactory.php
NOTES:
- make a Tweet model (+ a factory, migration, controller)
    => run "php artisan make:model Tweet -fmc"
- go into the tweets migration file (database/migrations/...create_tweets_table.php)
    => create an eloquent relationship: 
        => a tweet belongs to a user
        i.e. $table->foreignId('user_id');
             $table->string('body');
- migrate database
    => run "php artisan migrate"
- go into Tweet factory
    => factories are use to create instances of models (i.e. when seeding your datatbase)
    => this factory will create tweets (with a body and a user who created it)
- go into tinker (run "php artisan tinker")
    => can create a tweet and save to DB
    => factory('App\Tweet')->create()
    => factory('App\Tweet', 4)->create(['user_id' => 1])
- display the saved tweets
    => when the /home screen is loaded pass in the tweets (via the auth()->user()->timeline() method on the User model), grabs the appropriate tweets as $tweets
    => now can access the $tweets in the view
- create tweet functionality
    => add method and action for the tweet box form ('POST' & '/tweets')
    => create '/tweets' route in web.php that will direct to the TweetsController's store() method
    => the store() method validates the request, saves the tweet to the DB, and redirects back to the homepage
    => check for failed validation
    =>

### 4. Build a Following
It wouldn't be much of a Twitter-clone if we didn't allow users to follow one another. Let's begin implementing that functionality now.
FILES WORKED WITH:
- User.php
- database/migrations/...create_follows_table.php
NOTES:
- go into the User model
    => create an eloquent relationship: 
        => a user belongs to/follows many other users
        => create a new migration table
            => run "php artisan make:migration create_follows_table"
            => this will be a pivot table that describes the relationship between a user and the users they follow
            => 2 foreign keys (current user + user they follow)
        => migrate DB
            => run "php artisan migrate"
- add a follow relationship ($user follows #user2)
    => go into tinker
        => run "php artisan tinker"
        => $user = App\User::find(1)
        => $user2 = App\User::find(2)
        => $user->follow($user2)

### 5. Expanding the Timeline
Now that we have the necessary functionality to follow other Tweety users, we can fully expand the timeline to include all relevant posts.
FILES WORKED WITH:
- web.php
- RouteServiceProvider.php
- User.php
NOTES:
- moved the index() method insode HomeController to TweetController & delete HomeController.php
- change the variable HOME in RouteServiceProvider.php to be equal to '/tweets' instead of '/home'
- add a route middleare for '/tweets' endpoint
- expand the timeline to display all the tweets from the user's followers
    => create a new eloquent relationship in the User.php model
        => tweets() method that will grabs the tweets of a particular user
        => update the timeline() method to show the tweets of the current user + the tweets of the users they follow
- go into tinker and create a new tweet for one of the users the current user follows
    => factory('App\Tweet')->create(['user_id' => 3])

### 6. Construct a Profile Page
Let's move on and implement a profile page for each user. This page should show their avatar, a short bio, and then a timeline their tweets. This lesson will give us the chance to flex our Tailwind chops!
FILES WORKED WITH:
- home.blade.php => index.blade.php
- TweetsController.php
- app.blade.php
- web.php
- ProfilesController.php
- User.php
- profiles/show.blade.php
- _tweet.blade.php
- _timeline.blade.php
NOTES:
- clean up the folder/file system a bit
    => create a tweets folder in the views
    => rename "home.blade.php" to be "index.blade.php" 
    => move "inde.blade.php" into the tweets folder
    => inside the index() method of the TweetsController, change the view from "home" to be "tweets.index"
- create the profile page
    => in the routes file web.php add a route to view a profile
        => Route::get('/profiles/{user}', 'ProfilesController@show');
    => create the associated controller
        => run "php artisan make:controller ProfilesController"
    => add the show method to the controller
        => add the paramter it accepts (the User $user)
        => the $user will be passed in as the route wildcard value
        => by default, laravel is assuming that the route key name ($user) is the id of the user
        => to override this, go to the User model and override the getRouteKeyName() method
            => return the name of the key (attribute in the DB) that should be used for route model binding (usually the primary key)
            => in this case we want to change it to 'name'
        => return the view that shows the profile (profiles.show) and pass in the user clicked on
    => now that the endpoint '/profiles/{user}' works, create a link that requests this endpoint
        => in _tweet.blade.php, wrap the avatar and user name in a tags
        => set the href='/profiles/{{ $tweet->user->name }}'
        => do the same thing for the friends list
- go into the _sidebar-links.blase.php
    => add the route "/tweets" to the "Home" link
    => add the route "/profiles/{{ auth()->user()->name }}" to the "Profile" link
- go into the tweets/index.blade.php file, we can re-use the timeline in the profile
    => create a _timeline.blade.php partial
    => extract the timeline out of the tweets/index.blade.php and put it into the _timeline.blade.php
- in the _timeline.blade.php, 
    => include a "joined at..." p
        => need to transform the "created_at" to a readable date
            => i.e. $user->created_at->diffForHumans()
        => By default, Eloquent will convert the created_at and updated_at columns to instances of Carbon, which provides an assortment of helpful methods, and extends the native PHP DateTime class
        => check your composer.json file for nesbot/carbon package
            => if you do not have it, install Carbon:
            => run "composer require nesbot/carbon"
                => then in the view where you want to show the date...
                {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }} 
- need to add a border-radius of 20px to all the boxes, so need to change rouned-lg from 8px(0.5rem) to 20px(1.25rem)
    => run "npx tailwindcss init --full"
    => installs the full configuration file (gives you acces to more)
    => gives you a new tailwind config file (tailwind.confif.js)
    => go into that file
        => find the "border-radius" property
        => change the "border-lg" to value 1.25rem
    => recompile, run "npm run dev"

### 7. Nested Layout Files With Components
When building your own applications, you'll likely run into situations where you require nested layout files. Let's leverage Blade components to make the whole process a cinch.
FILES WORKED WITH:
- layouts/app.blade.php
NOTES:
- right now, if the user is not logged in and visits the "/tweets" page (or others), it will redirect to the login/register page, and will throw an error (b/c user-specific information is being requested in views such as "_sidebar-links" & "_friends-list" but it is not available b/c the user is not logged in)
    => this is happening b/c the layout file assumes the user is logged in
- to solve this...
    #1. go into layouts/app.blade.php, and add the following to limit the view to only logged in users (so IF the user is logged in, THEN display the sidebar view)
    <!-- @if(auth()->check())
            <div>
                @include('_sidebar-links')
            </div>
        @endif -->
    #2. use blade components (just a way to structure things)
        => add a new directory in the "views" directory called "components"
        => inside this directory, create a "master layout component" called "master.blade.php"
        => move everything from "layouts/app.blade.php" into "master.blade.php"
            => remove everything except the "skin" i.e. keep the head, wrapping div, and header
            => replace what you remove with a default "slot"
            i.e. {{ $slot }}
        => now you have a generic master page
        => next, create an "app component"
            => put your content inside of <x-master></x-master> tags
            => everything inside will be put into the "slot" in the master component
        => next, replace the @extends('layouts.app')/@section('content')@endsection with <x-master></x-master> 

        ** not working... are the right files being called now (components)???