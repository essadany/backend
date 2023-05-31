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
        Schema::create('claims', function (Blueprint $table) {
            $table->increments('id');
            $table->string('internal_ID')->unique();
            $table->string('refRecClient');
            $table->string('product_ref');
            $table->string('engraving');
            $table->date('prod_date');
            $table->string('object');
            $table->date('opening_date');
            $table->string('final_cusomer')->nullable();
            $table->string('claim_details');
            $table->string('def_mode');
            $table->integer('nbr_claimed_parts');
            $table->date('returned_parts')->nullable();
            $table->timestamps();
        });
        Schema::table('claims', function (Blueprint $table) {
            $table->foreign('product_ref')->references('product_ref')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
