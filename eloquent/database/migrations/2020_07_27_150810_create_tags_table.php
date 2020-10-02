<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // pivot table 
        // how to get pivot table name (convention):
        // 1. take the two tables: 'articles' + 'tags'
        // 2. make each singular: 'article' + 'tag'
        // 3. connect with an underscore: 'article_tag' 
        // 4. put in alphabetical order: 'article_tag'
        Schema::create('article_tag', function (Blueprint $table) {
            $table->id();
            // connection to article
            $table->unsignedBigInteger('article_id');
            // connection to tag
            $table->unsignedBigInteger('tag_id');
            $table->timestamps();
            // unique key => the combination of the 'article_id' and 'tag_id' must be unique (prevents duplicates) how???
            $table->unique(['article_id', 'tag_id']);
            // articles foreign key
            $table->foreign('article_id')
                ->references('id')
                ->on('articles')
                ->onDelete('cascade');
             // tags foreign key
            $table->foreign('tag_id')
                ->references('id')
                ->on('tags')
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
        Schema::dropIfExists('tags');
    }
}
