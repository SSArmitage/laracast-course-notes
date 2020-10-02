# About this lesson (5 lessons)

## ***** AUTHORIZATION *****
### 1. Limit Access To Authorized Users
For any typical web application, some actions should be limited to authorized users. Perhaps only the creator of a conversation may select which reply best answered their question. If this is the case, we'll need to write the necessary authorization logic. I'll show you how in this lesson!
FILES WORKED WITH:
- web.php
- ConversationsController.php
- Conversation.php
- views/conversations/index.blade.php
- views/conversations/show.blade.php
- database/migrations/...create_users_table
- database/migrations/...create_conversations_table
- database/migrations/...create_replies_table
- database\seeds\ConversationSeeder.php
- database\factories\UserFactory.php
- database\factories\ConversationFactory.php
- app\Providers\AuthServiceProvider.php
- vendor\laravel\framework\src\Illiminate\Auth\Access\Gate.php
- app\Policies\ConversationPolicy.php
NOTES:
- create database
- set up migrations
    i.e. for the conversations table, run "php artisan make:migration create_conversations_table"
    => The migration will be placed in your database/migrations folder, and will contain a timestamp which allows the framework to determine the order of the migrations
    => make sure to include foreign keys for eloquent relationships
    => run all outstanding migrations, run "php artisan migrate"
    => after altering a migration (i.e. adding a column) run, "php artisan migrate:refresh"
        => Rollback all migrations and run them all again
- create eloquent relationships (one-to-many)
    => a user can have many conversations
    => a conversation can belong to one user
    => a conversation can have many replies
    => a reply can belong to one conversation
    => a user can have many replies
    => a reply can belong to one user
- set up routes & views & controller actions
- set up seed classes
    => Laravel includes a simple method of seeding your database with test data using seed classes
    => All seed classes are stored in the database/seeds directory
    => By default, a DatabaseSeeder class is defined for you. From this class, you may use the call method to run other seed classes, allowing you to control the seeding order
    => To generate a seeder, run 'php artisan make:seeder ConversationSeeder'
    => By default, the db:seed command runs the DatabaseSeeder class, which may be used to call other seed classes. However, you may use the --class option to specify a specific seeder class to run individually
    => To seed individual, run 'php artisan db:seed --class ConversationSeeder'
    => A seeder class only contains one method by default: run. This method is called when the db:seed Artisan command is executed.
        => Within the run method, you may insert data into your database
        => i.e via the query builder to manually insert data or you may use Eloquent model factories
            => Model Factory lets us define a pattern used in generating fake data
            => define factory, run 'php artisan make:factory ConversationFactory'
    => Once you have written your seeder, you may need to regenerate Composer's autoloader using the dump-autoload command, run 'composer dump-autoload'
    => You may also seed your database using the migrate:fresh command, which will drop all tables and re-run all of your migrations. This command is useful for completely re-building your database:
        => run, 'php artisan migrate:fresh --seed'

GOAL:
- the creator of the conversation may choose any of the replies as the "best reply" to the conversation
    => need some kind of authorization
    => only the creator of the conversation/thread is authorized to choose the best reply
        => in the conversation migration file, need to have a column that records the id of the "best reply"
    => conditionally display element ("best reply" button)
        => can use the blade directive "@can" with a Gate class
            => in your AuthServiceProvider.php boot() method define a key on the Gate class i.e. "update-conversation"
            => associate the key with a condition (inside a closure)
            => refernce the key in a view to conditionally render something
        => can also use a dedictaed Policy class (a class that encapsulates an authorization policy for a model) => i.e. for whether you can see a conversation, update a conversation
            => i.e. a Conversation model will have a ConversationPolicy class
            => ** use a policy class, unless the authorization logic is very trivial **
            => run "php artisan make:policy ConversationPolicy --model=Conversation"
            => --model=Conversation => associates the policy with the appropriate model (scaffolds a bunch of methods)
            => use the desired method (here just using the update() method)
            => can remove the Gate::define() code in the AuthServiceProvider.php boot() method
            => in the controller method that is checking the authorization status (i.e. ConversationsBestReplyController@show), change to the following:
                $this->authorize('update', $reply->conversation);
                => where 'update' now refers to the update() method on the ConversationPolicy class
            => behind the scenes Laravel creates a map from the Conversation model to the ConversationPolicy
    => also need to prevent a user from manually submitting a POST request to try to mark a reply as the "best reply"
        => server-side prevention
        => when the POST request is made to the route, the associated controller will check to see if the current user has permission to update the conversation (allows them to choose the "best reply"), by calling the authorize() method 
- ** move conditional logic to model **

HOMEWORK:
- The creator of a conversation can update a thread, but the administrator can as well
- How to implement administrator privaliges into policy

### 2. Authorization Filters (authorization hooks)
There will almost certainly be users in your application who should receive special privileges and access. As examples, consider a forum moderator or site administrator. In these cases, we can declare before and after authorizations filters before the intended policy ability is tested.
FILES WORKED WITH:
- app\Policies\ConversationPolicy.php
- app\Providers\AuthServiceProvider.php
NOTES:
- Setting up before and after authroization hooks
- Can put authorization hook inside of the ConversationPolicy.php, but this means that if you are checking for an administrator, this check would have to be done for every single policy, instead...
- Can set up GLOBAL before and after authroization hooks
    => set up globally in the AuthServiceProvider.php 
    => handle it in the boot() method

### 3. Guessing the Ability Name
Here's an optional feature that you might consider. If you exclude the ability name when authorizing from your controllers, Laravel will do it's best to guess the appropriate policy method to call. It does so by creating a map for the typical restful controller actions and their associated policy methods.
FILES WORKED WITH:
- app\Http\Controllers\ConversationBestReplyController.php
- app\Http\Controllers\Controller.php
-vendor\laravel\framework\src\Illuminate\Foundation\Auth\Access\AuthorizesRequests.php
NOTES:
- the authorize() method called in ConversationBestReplyController.php store() method
    => under the hood...
    => ConversationBestReplyController class is extended from the Controller class, which uses the AuthorizesRequests trait
    => the AuthorizesRequests trait has the authorize() method
        => inside authorize() method, laravel parses the passed in ability + argument by checking if you specified an explicit abiltiy name ("update" in this case)
            => if you didnt it reads the controller action's method name and tries to guess the ability based on that (in order to know which policy method to call)
            => it reads a resourceAbilityMap (a mapping between the controller action and the associated policy name)
            i.e. in this case it would be "store" => "create" 
            => but this wont work b/c there is no "create" ability, and we want the "update" ability
- *** up to you how to do it => I would be explicit and include the ability name in the authorize() method call *** 

### 4. Middleware-Based Authorization
If you'd prefer not to execute authorization from within your controller actions, you can instead handle it as a route-specific middleware. I'll show you how in this episode.
FILES WORKED WITH:
- web.php
- ConversationsController.php
- app\Policies\ConversationPolicy.php
NOTES:
- authorizing a request in a controller action vs on the router level
- i.e. a user can only view an conversation if they created it (like a draft or something)
    => controller level:
        => in the ConversationsController show() method, in order to show/see a conversation, you must first authorize the current user to see if they created it
        $this->authorize('view', $conversation);
        => in the ConversationPolicy, add a view() method (view ability)
    => router level (middleware):
        => in the routes file (web.php), add a middleware to the view individual conversation route
        => "can" => identifier is "can" (like in the blade directives)
        => "view" => ability name
        => "conversation" => wildcard (if this is equal to the {wildcard} it will use route model binding - references the wildcard name => it will grab the wildcard value for id and then automatically use that id to grab the associated conversation)
        Route::get('conversations/{conversation}','ConversationsController@show')->middleware('can:view, conversation');
- preference 
    => do you want your authorization to be performed as a route middleware or directly within a controller action

### 5. Roles & Abilities
Let's take things up a notch. Beginning with a fresh Laravel installation, let's build a full role-based authorization system that allows us to dynamically grant and revoke various abilities on a per-user basis.
FILES WORKED WITH:
- database/migrations/...create_roles_tables
- App\Role.php
- App\Ability.php
- App\User.php
- routes/web.php
- resources/views/welcome.blade.php
- app\providers\AuthServiceProvider.php
NOTES:
- users play roles
- different roles come with different abilities
    i.e. moderator => 'edit_forum'
         owner => 'view_financial_reports'
- set up roles tables in the database, create DB migrations
    => run "php artisan make:migration create_roles_tables"
    => remove th down() method (instead when you want to make a change, create a new migration, and make the change there)
- Set up eloquent relationships
    => create a Role model
        => run "php artisan make:model Role"
        => inside of the model, add an abilities() method & allowTo() method
    => create an Ability model
        => run "php artisan make:model Ability"
        => inside of the model, add a roles() method method
    => in the User model add a roles() & assignRole() method
- Open Tinker, run "php artisan tinker"
    => grab the first user
        => $user = User::find(1);
    => grab or create a role
        => $role = App\Role::firstOrCreate([
            'name' => 'moderator'
        ]);
    => grab or create an ability
        => $ability = App\Ability::firstOrCreate([
            'name' => 'edit_forum'
        ]);
    => add the ability to the role (create the connection between the role and the ability)
        => $role->allowTo($ability);
    => assign a role to a user (create the connection between the role and a user)
        => $user->assignRole($role);
    => get all the abilities associated with the user (not an eloquent relationship)
        => grab all the roles associated with the user, map over each role, grab the abilities associated with that role
            i.e. $user->roles->map->abilities
            => higher-order collections 
            => calls map on a colelction, iterates over each user instance and calls the abilities() method on it
        => this returns a collection of collections... not done yet
        => flatten down to a single collection this using flatten()
            i.e. $user->roles->map->abilities->flatten();
        => also, d/n need the full ability instance, just want the 'name' of the ability, using pluck()
            i.e. $user->roles->map->abilities->flatten()->pluck('name');
        => then to ensure you are not getting repeats, use unique()
            i.e. $user->roles->map->abilities->flatten()->pluck('name')->unique();
        *** can put the above in an abilities() method in the User model
- go to the 'welcome' view, add a link, this link should onle be visible to the user if they have permission (guests by default do not have access)
    => add the @can/@endcan blade directives (is there an alternative?), with the 'edit_form' ability
- go to the AuthServiceProvider and define the ability name 'edit_form' in the boot() method
    => at this point, you d/n have access to the authenticated user
    => set a global gate before filter (runs before any authorization)
        i.e. Gate::before(function($user, $ability) {
            return $user->abilities()->contains($ability);
        })
        => the $ability is passed through from the view that is running the authorization check (in order to view the edit link) i.e. 'edit_form'
        => at the point the callback is triggered, there is an authenticated user (the person who signed in)
        => check if the user qualifies for the ability (using their own list of abilities), read that array and check if it contains the particular ability
            i.e. $user->abilities()
*** TAKEAWAY: can create abilities and hook them into laravel's Gate functionality using the global "before" hook *** 
 