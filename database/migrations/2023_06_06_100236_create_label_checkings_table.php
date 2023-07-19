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
        Schema::create('label_checkings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('claim_id')->unsigned();
            $table->string('sorting_method')->nullable();
            $table->enum('bontaz_plant',['Morocco','France','Italy','Germany', 'Poland','China','Mexico','Tunisia'])->nullable();
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
        Schema::dropIfExists('label_checkings');
    }
};
