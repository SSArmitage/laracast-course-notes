<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            // columns in the new table
            $table->id();
            // id() => Alias of $table->bigIncrements('id') - install came with this as the primary key
            // bigIncrements() => unsigned primary key with the type = big integer => Incrementing ID using a "big integer" equivalent.
            // $table->bigIncrements('id');
            // foreign key -> way to associate an article with a user
            // by default in laravel migrations, the primary key will be set to an unsigned big integer, so when we set our foreign keys we want to make sure that they match up (primary and foreign references must be of same type)
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('excerpt');
            // thumbnail path
            // $table->string('thumb');
            $table->text('body');
            $table->timestamps();
            // need a foreign key constraint - the foreign key called 'user_id' references the 'id' column on the 'users' table, and if the user is deleted, we should cascade and delete all the user's articles
            $table->foreign('user_id')
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
        Schema::dropIfExists('articles');
    }
}
