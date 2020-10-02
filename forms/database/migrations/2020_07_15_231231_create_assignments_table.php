<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->text('body');
            // timestamp version: 2 pieces of info (if its completed & date it was completed)
            // $table->timestamp('completed_at')->nullable();
            // boolean version: 1 piece of info (if its completed)
            // set default to be false
            $table->boolean('completed')->default(false);
            $table->timestamps();
            $table->timestamp('due_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
}
