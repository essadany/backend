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
        Schema::create('five_lignes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('five_why_id')->unsigned();
            $table->enum('type',['detection','occurence','system'])->nullable();
            $table->string('why')->nullable();
            $table->string('answer')->nullable();
            $table->timestamps();

            $table->foreign('five_why_id')->references('id')->on('five_whys')
            ->cascadeOnUpdate()
            ;	
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('five_lignes');
    }
};
