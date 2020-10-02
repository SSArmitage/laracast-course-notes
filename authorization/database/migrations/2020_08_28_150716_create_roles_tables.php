<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // TABLE 1
        // this table includes all the possible roles a user can have
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            // name of role i.e. manager, moderator, subscriber, etc
            $table->string('name');
            // custom name may be different from the actual name, this custom name is what will be displayed to the user
            // nullable() => not required
            $table->string('label')->nullable();
            $table->timestamps();

        });

        // *** MANY-TO-MANY RELATIONSHIP ***
        // need a table to store the connection between a particular role and particular ability (TABLE 3) - pivot table
        // a role can have many abilities & an ability can belong to many roles
        // need a table to store the connection between a particular role and particular user (TABLE 4) - pivot table
        // a user can have many roles & a role can belong to many users

        // TABLE 2
        // this tables includes all the possible abilities
        // each role includes different abilites/permissions
        Schema::create('abilities', function(Blueprint $table) {
            $table->bigIncrements('id');
            // name of ability i.e. 'edit_forum'
            $table->string('name');
            // custom name may be different from the actual name, this custom name is what will be displayed to the user i.e. 'Edit the forum'
            // nullable() => not required
            $table->string('label')->nullable();
            $table->timestamps();
        });

        // TABLE 3
        // the pivot table name is comprised of the table names, singluar, seperatued by "_", and in alphabetical order
        Schema::create('ability_role', function(Blueprint $table) {
            // primary key => combination of the 'role_id' and 'ability_id'
            // could have also done a regular primary key here and set 'role_id' & 'ability_id' to be unique
            $table->primary(['role_id', 'ability_id']);
            // reference to role id
            $table->unsignedBigInteger('role_id');
            // reference to the ability id
            $table->unsignedBigInteger('ability_id');
            // timestamps
            $table->timestamps();
            // need a foreign key constraint - the foreign key called 'role_id' references the 'id' column on the 'roles' table, and if the role is deleted, we should cascade and delete all the records
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');
            // need a foreign key constraint - the foreign key called 'ability_id' references the 'id' column on the 'abilities' table, and if the ability is deleted, we should cascade and delete all the records
            $table->foreign('ability_id')
                ->references('id')
                ->on('abilities')
                ->onDelete('cascade');
        });

        // TABLE 4
        // the pivot table name is comprised of the table names, singluar, seperatued by "_", and in alphabetical order
        Schema::create('role_user', function(Blueprint $table) {
            // primary key => combination of the 'role_id' and 'user_id'
            // could have also done a regular primary key here and set 'role_id' & 'user_id' to be unique
            $table->primary(['user_id', 'role_id']);
            // reference to role id
            $table->unsignedBigInteger('user_id');
            // reference to the ability id
            $table->unsignedBigInteger('role_id');
            // timestamps
            $table->timestamps();
            // need a foreign key constraint - the foreign key called 'role_id' references the 'id' column on the 'roles' table, and if the role is deleted, we should cascade and delete all the records
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
            // need a foreign key constraint - the foreign key called 'ability_id' references the 'id' column on the 'abilities' table, and if the ability is deleted, we should cascade and delete all the records
            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
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
        // 
    }
}
