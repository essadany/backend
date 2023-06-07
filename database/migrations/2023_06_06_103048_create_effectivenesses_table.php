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
        Schema::create('effectivenesses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned()->nullable();
            $table->string('title')->nullable();
            $table->string('file')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('reports')
            ->cascadeOnUpdate()
            ->nullOnDelete();	
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('effectivenesses');
    }
};
