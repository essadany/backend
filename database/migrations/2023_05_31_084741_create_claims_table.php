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
            $table->enum('category',['AQI', 'CC','Field'])->nullable();
            $table->string('customer')->nullable();
            $table->string('product_ref');
            $table->string('customer_part_number')->nullbale();
            $table->string('engraving')->nullable();
            $table->date('prod_date')->nullable();
            $table->string('object')->nullable();
            $table->date('opening_date')->nullable();
            $table->date('done_date')->nullable();
            $table->string('claim_details')->nullable();
            $table->string('def_mode')->nullable();
            $table->integer('nbr_claimed_parts');
            $table->enum('status',['on going', 'done','delayed'])->default('on going');
            $table->boolean("deleted")->default(false);
            $table->timestamps();


            $table->foreign('product_ref')->references('product_ref')->on('products')
            
            ->cascadeOnUpdate();
            

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
