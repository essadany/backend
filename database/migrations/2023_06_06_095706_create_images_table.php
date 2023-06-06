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
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('problem_id')->unsigned()->nullable();
            $table->integer('report_id')->unsigned()->nullable();
            $table->integer('annexe_id')->unsigned()->nullable();
            $table->integer('label_check_id')->unsigned()->nullable();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('bloob');
            $table->boolean('isGood')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('problem_id')->references('id')->on('problem_descriptions')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
            $table->foreign('report_id')->references('id')->on('reports')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
            $table->foreign('annexe_id')->references('id')->on('annexes')
            ->cascadeOnUpdate()
            ->restrictOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
