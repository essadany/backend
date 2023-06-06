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
            $table->string('sorting_method');
            $table->enum('bontaz_plant',['El Jadia','Shanghai','Marnaz','Fouchana', 'Velka Dobra','Viana Do Casteo','Troy','Pingamonhangaba-sp']);
            $table->timestamps();



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
