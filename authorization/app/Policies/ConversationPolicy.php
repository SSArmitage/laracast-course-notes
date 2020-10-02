<?php

namespace App\Policies;

use App\Conversation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

// ** for this exercise, we only need the update() & before() method **
class ConversationPolicy
{
    use HandlesAuthorization;

    // this fires "before" the authorization ability is tested
    // run before all other authorization checks
    // call also do a similar after() method
    // public function before(User $user) {
    //     // check the user id (Sheldon Cooper has id of 1)
    //     // can also check the user's admin status (admin column in user table - boolean), or the user's role (role column in the user table)
    //     // NOTE: if you return a non-null value from the before hook, the update() method wont get called, b/c the result is assumed to be the response
    //     // If the before() returns a non-null result that result will be considered the result of the check (instead put it in an if statement, that way the method will only return true/non-null when the user is the admin)
    //     // when this if statement fails (the current user is not the admin), this before() method will return null, and the update() method will be called
    //     if ($user->id === 1) { // admin
    //         return true;
    //     }

    // }

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function view(User $user, Conversation $conversation)
    {
        return $conversation->user->is($user);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function update(User $user, Conversation $conversation)
    {
        return $conversation->user->is($user);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function delete(User $user, Conversation $conversation)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function restore(User $user, Conversation $conversation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\User  $user
     * @param  \App\Conversation  $conversation
     * @return mixed
     */
    public function forceDelete(User $user, Conversation $conversation)
    {
        //
    }
}
