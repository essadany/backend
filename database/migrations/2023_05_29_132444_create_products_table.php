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
            $table->integer("customer_id")->unsigned()->nullable();
            $table->string("name");
            $table->enum("zone",['Module', 'Bobine','Faiscaux','Clapet','Gicleur','Vanne']);
            $table->string("uap")->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
