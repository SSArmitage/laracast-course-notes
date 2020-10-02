<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    //  moving forward when you run your migrations (create table/column)
    public function up()
    {
        Schema::create('posts2', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->text('body');
            // timestamps => default, add updated time stamps to a table
            $table->timestamps();
            // additional timestamp
            // nullable() => when you prepare a new post the '' column is optional, and can be set at a later date
            $table->timestamp('published_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    //  roll back or undo a migration (drop a table/column)
    public function down()
    {
        Schema::dropIfExists('posts2');
    }
}
