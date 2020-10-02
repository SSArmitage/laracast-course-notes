<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use app\User;
use app\Conversation;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Lecture #
        // global "before" hook
        // Sometimes, you may wish to grant all abilities to a specific user. You may use the before() method to define a callback that is run before all other authorization check
        // If the before callback returns a non-null result THAT result will be considered the result of the check (i.e. if the user is the admin, this callback will return true/non-null)
        // otherwise (if not the admin), continue on with the check
        // Gate::before(function(User $user) {
        //     if ($user->id === 1) { // admin
        //         return true;
        //     }
        // });

        // Lecture #5
        Gate::before(function($user, $ability) {
            return $user->abilities()->contains($ability);
        });

        // use Laravel's Gate class => createa a "gate" between the user and some action that they might want to perform
        // define() => define a new policy
        // requires the user to be logged in (if user is not authenticated, the closure will return false, and the "gate" will remain closed), if the user is logged in it proceeds to determine if this "update-conversation" condition is true
        // if you want guests to pass, make the user optional with "?User $user"
        // 'update-conversation' => key (reference this key in a view to use this conditional - using the @can blade directive)
        // Gate::define('update-conversation', function(User $user, Conversation $conversation) {
        //     // the user can update a conversation if it was written by that user
        //     // first grab the user that wrote the conversation, and then check if that user is the same as the currently logged in user
        //     // if true, gates open, they are authorized to update the conversation
        //     return $conversation->user->is($user);
        // });
    }
}
