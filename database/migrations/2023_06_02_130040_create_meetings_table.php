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
        Schema::create('meetings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type')->nullable();
            $table->integer('team_id')->unsigned();
            $table->date('date')->nullable();
            $table->time('hour')->nullable();
            $table->string('comment')->nullable();
            $table->boolean("deleted")->default(false);
            $table->timestamps();

            $table->foreign('team_id')->references('id')->on('teams')
            ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};
