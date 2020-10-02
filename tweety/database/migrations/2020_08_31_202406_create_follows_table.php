<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFollowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // describes the relationship between a user and the users they follow
        // i.e. the user with an id=1 follow a user with id=2, the user with an id=1 also follow a user with id=3
        // pivot table
        // foreignId() => new, same as unsignedBigInteger()
        Schema::create('follows', function (Blueprint $table) {
            $table->primary(['user_id', 'following_user_id']);
            // connect to the current user - create column for current user
            $table->foreignId('user_id');
            // create column for user they follow - connect to the users they follow
            $table->foreignId('following_user_id');
            $table->timestamps();

            // foreign key constraint for current user
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            // foreign key constraint for user they follow
            $table->foreign('following_user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('follows');
    }
}
