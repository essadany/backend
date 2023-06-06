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
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ishikawa_id')->unsigned();
            $table->enum('type',['Person','Machine','Materials','Method', 'Management', 'Measurment', 'Environment', 'Money']);
            $table->string('input');
            $table->boolean('isPrincipale');
            $table->enum('status',['on going','confirmed','not confirmed']);
            $table->string('influence');
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('ishikawa_id')->references('id')->on('ishikawas')
            ->cascadeOnUpdate()
            ->restrictOnDelete();	
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
