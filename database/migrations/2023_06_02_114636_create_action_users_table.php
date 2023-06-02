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
        Schema::create('action_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_id');
            $table->string('comment');
            $table->date('comment_date');
            $table->timestamps();

            $table->foreign('action_id')->references('id')->on('actions')
            ->cascadeOnUpdate()
            ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('action_users');
    }
};
