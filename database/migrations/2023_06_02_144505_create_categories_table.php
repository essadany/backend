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
            $table->string('input')->nullable();
            $table->boolean('isPrincipale')->default(false);
            $table->enum('status',['on going','confirmed','not confirmed'])->nullable();
            $table->string('influence')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();

            $table->foreign('ishikawa_id')->references('id')->on('ishikawas')
            ->cascadeOnUpdate()
            ;	
            
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
