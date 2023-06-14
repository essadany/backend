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
        Schema::create('actions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('action');
            $table->enum('type',['containment','potential','implemented','preventive'])->default('containment');
            $table->string('pilot')->nullable();
            $table->date('planned_date');
            $table->date('start_date')->nullable();
            $table->enum('status',['not started','on going', 'done'])->default('not started')->default('not started');
            $table->date('done_date')->nullable();
            $table->boolean("deleted")->default(false);
            $table->timestamps();

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
        Schema::dropIfExists('actions');
    }
};
