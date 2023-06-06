<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meeting_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('meet_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->boolean('present');
            $table->string('comment')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')
            ->cascadeOnUpdate()
            ->restrictOnDelete();	
            $table->foreign('meet_id')->references('id')->on('meetings')
            ->cascadeOnUpdate()
            ->restrictOnDelete();	
            $table->foreign('team_id')->references('id')->on('teams')
            ->cascadeOnUpdate()
            ->restrictOnDelete();	
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_users');
    }
};
