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
        Schema::create('problem_descriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('claim_id')->unsigned();
            $table->string('what')->nullable();
            $table->string('who')->nullable();
            $table->string('where')->nullable();
            $table->string('when')->nullable();
            $table->string('why')->nullable();
            $table->string('how')->nullable();
            $table->integer('how_many_before')->nullable();
            $table->integer('how_many_after')->nullable();
            $table->boolean('recurrence')->default(false);
            $table->boolean('received')->default(false);
            $table->date('date_reception')->nullable();
            $table->date('date_done')->nullable();
            $table->date('due_date')->nullable();
            $table->enum('bontaz_fault',['YES','NO','NOT CONFIRMED'])->default('NOT CONFIRMED');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('claim_id')->references('id')->on('claims')
            ->cascadeOnUpdate()
            ;	

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problem_descriptions');
    }
};
