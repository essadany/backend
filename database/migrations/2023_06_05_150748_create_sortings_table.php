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
        Schema::create('sortings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('containement_id')->unsigned();
            $table->string('location_company');
            $table->integer('qty_to_sort');
            $table->integer('qty_sorted');
            $table->integer('qty_NOK');
            $table->boolean('scrap');
            $table->timestamps();

            $table->foreign('containement_id')->references('id')->on('containements')
            ->cascadeOnUpdate()
            ->restrictOnDelete();	
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sortings');
    }
};
