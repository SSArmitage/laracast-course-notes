<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // you can use model factories to conveniently generate large amounts of database records.
        // A basic User model usually has relations with other models. For example a user can have conversations, if we wanted to make a user have conversations using model factories, we can do this:
        // NOTE: This is assuming that you setup the Eloquent model relationship e.g hasMany etc
        // The attributes you pass to the create() function will be passed into your model definition callback as the second argument.

        // factory(App\User::class, 5)
        //     ->create()
        //     ->each(function ($user) {
        //         $user->conversations()->save(
        //                 factory(App\Conversation::class)->make()
        //              );
        //     });

        //create 10 users
        factory(App\User::class, 10)->create()->each(function ($user) {
            //create 5 posts for each user
            $user_id = ['user_id'=>$user->id];
            factory(App\Conversation::class, 5)->create($user_id); 
            // $factory->create(App\Conversation::class, ['user_id'=> $user->id]);   
        }); 

        // $faker = Faker\Factory::create();
        // factory(App\User::class, 10)->create();
        // $users = App\User::all();
        // foreach ($users as $user) {
        //     // factory(App\Conversation::class, 5)->create('user_id'=> $user->id]); 
        //     App\Conversation::create([
        //     'title' => $faker->words($nb = 3, $asText = false), 
        //     'body' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true),
        //     'user_id' => $user->id
        // ]);
        // };
    }
}
