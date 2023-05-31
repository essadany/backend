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
        Schema::create('products', function (Blueprint $table) {
            $table->increments("id");
            $table->string("product_ref")->unique();
            $table->string("customer_ref");
            $table->string("name");
            $table->enum("zone",['Module', 'Bobine','Faiscaux','Clapet','Gicleur']);
            $table->string("uap");
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('customer_ref')->references('customer_ref')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
