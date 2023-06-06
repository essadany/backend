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
        Schema::create('five_whys', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('claim_id')->unsigned();
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
        Schema::dropIfExists('five_whys');
    }
};
