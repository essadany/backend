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
        Schema::create('ppm', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('year')->nullable();
            $table->string('month')->nullable();
            $table->string('week')->nullable();
            $table->integer('shipped_parts')->nullable();
            $table->float('ppm')->nullable();
            $table->float('objectif')->default(3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppm');
    }
};
