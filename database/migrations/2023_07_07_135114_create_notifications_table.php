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
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('message')->nullable();
            $table->timestamp('notification_date')->useCurrent();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->foreign('action_id')->references('id')->on('actions')
            ->cascadeOnUpdate()
            ;
            $table->foreign('user_id')->references('id')->on('users')
            ->cascadeOnUpdate()
            ;
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
