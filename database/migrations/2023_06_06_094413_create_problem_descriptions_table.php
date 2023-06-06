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
            $table->string('what');
            $table->string('who');
            $table->string('where');
            $table->string('when');
            $table->string('why');
            $table->string('how');
            $table->string('how_many_before');
            $table->string('how_many_after');
            $table->boolean('recurrence');
            $table->boolean('received');
            $table->date('date_reception')->nullable();
            $table->string('date_done');
            $table->boolean('bontaz_fault');
            $table->string('description');
            $table->timestamps();

            $table->foreign('claim_id')->references('id')->on('claims')
            ->cascadeOnUpdate()
            ->restrictOnDelete();	

            
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
