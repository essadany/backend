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
            $table->integer("customer_id")->unsigned();
            $table->string("name");
            $table->enum("zone",['Salle Grise 1', 'Salle Grise 2','Salle Grise 3','Gicleur & Clapet','Fx Bobine Injection','Vanne motorisée']);
            $table->string("uap")->nullable();
            $table->boolean("deleted")->default(false);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')
            ->onUpdate('cascade');
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
