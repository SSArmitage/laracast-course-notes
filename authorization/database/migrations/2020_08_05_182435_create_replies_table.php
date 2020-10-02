<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            // connection to user
            $table->unsignedBigInteger('user_id');
            // connection to conversation
            $table->unsignedBigInteger('conversation_id');
            $table->text('body');
            $table->timestamps();
             // need a foreign key constraint - the foreign key called 'user_id' references the 'id' column on the 'users' table, and if the user is deleted, we should cascade and delete all the user's articles
            // users foreign key
            // $table->foreign('user_id')
            //     ->references('id')
            //     ->on('users')
            //     ->onDelete('cascade');
            // // conversations foreign key
            // $table->foreign('conversation_id')
            //     ->references('id')
            //     ->on('conversation')
            //     ->onDelete('cascade');
        });

        // table that connects the replies to conversations
        Schema::create('conversation_reply', function(Blueprint $table) {
            // primary key => combination of the 'role_id' and 'ability_id'
            // could have also done a regular primary key here and set 'role_id' & 'ability_id' to be unique
            $table->primary(['conversation_id', 'reply_id']);
            // reference to role id
            $table->unsignedBigInteger('conversation_id');
            // reference to the ability id
            $table->unsignedBigInteger('reply_id');
            // timestamps
            $table->timestamps();
            // need a foreign key constraint - the foreign key called 'role_id' references the 'id' column on the 'roles' table, and if the role is deleted, we should cascade and delete all the records
            $table->foreign('conversation_id')
                ->references('id')
                ->on('conversations')
                ->onDelete('cascade');
            // need a foreign key constraint - the foreign key called 'ability_id' references the 'id' column on the 'abilities' table, and if the ability is deleted, we should cascade and delete all the records
            $table->foreign('reply_id')
                ->references('id')
                ->on('replies')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replies');
    }
}
