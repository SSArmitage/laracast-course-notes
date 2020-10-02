<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * Using the call method allows you to break up your database 
     * seeding into multiple files
     *
     * @return void
     */
    public function run()
    {
        // i.e.
        // $this->call(UserSeeder::class);
        // $this->call([
        //     UserSeeder::class,
        //     PostSeeder::class,
        //     CommentSeeder::class,
        // ]);
        // $this->call(ConversationSeeder::class);
    }
}
