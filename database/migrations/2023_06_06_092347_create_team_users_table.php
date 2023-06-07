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
        Schema::create('team_users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->unsigned()->nullable();
            $table->integer('team_id')->unsigned()->nullable();
            $table->timestamps();

           $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()
           ->nullOnDelete();	
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnUpdate()
            ->nullOnDelete();	

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_users');
    }
};
