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
            $table->integer('problem_id')->unsigned();
            $table->integer('report_id')->unsigned();
            $table->integer('annexe_id')->unsigned();
            $table->integer('label_check_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('type')->nullable();
            $table->string('bloob');
            $table->boolean('isGood')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('problem_id')->references('id')->on('problem_descriptions')
            ->cascadeOnUpdate()
            ;
            $table->foreign('report_id')->references('id')->on('reports')
            ->cascadeOnUpdate()
            ;
            $table->foreign('annexe_id')->references('id')->on('annexes')
            ->cascadeOnUpdate()
            ;

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
