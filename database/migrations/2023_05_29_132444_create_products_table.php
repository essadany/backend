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
            $table->unsignedInteger("customer_code");
            $table->string("name")->nullable();
            $table->enum("zone",['Salle Grise 1', 'Salle Grise 2','Salle Grise 3','Gicleur & Clapet','Fx Bobine Injection','Vanne motorisée']);
            $table->boolean("deleted")->default(false);
            $table->timestamps();

            $table->foreign('customer_code')->references('code')->on('customers')
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
