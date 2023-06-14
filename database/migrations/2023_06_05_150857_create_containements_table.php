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
        Schema::create('containements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('report_id')->unsigned();
            $table->string('method_description')->nullable();
            $table->string('method_validation')->nullable();
            $table->string('risk_assesment')->nullable();
            $table->timestamps();

            $table->foreign('report_id')->references('id')->on('reports')
            ->cascadeOnUpdate()
            ;	
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('containements');
    }
};
