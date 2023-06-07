nullOnDelete<?php

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
        Schema::create('reports', function (Blueprint $table) {
            $table->increments('id');
            $table->string('report_ref')->nullable();
            $table->date('due_date')->nullable();
            $table->date('sub_date')->nullable();
            $table->string('contianement_actions')->nullable();
            $table->string('first_batch3')->nullable();
            $table->string('first_batch6');
            $table->date('date_cause_definition')->nullable();
            $table->string('reported_by')->nullable();
            $table->string('pilot')->nullable();
            $table->boolean('ddm')->default(false);
            $table->boolean('approved')->default(false);
            $table->boolean('others')->default(false);
            $table->boolean('ctrl_plan')->default(false);
            $table->boolean('pfmea')->default(false);
            $table->boolean('dfmea')->default(false);
            $table->string('progress_rate')->nullable();
            $table->timestamps();

            $table->foreign('report_ref')->references('internal_ID')->on('claims')
            ->cascadeOnUpdate()
            ->nullOnDelete();	
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
