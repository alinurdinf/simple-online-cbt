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
        Schema::create('test_results', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->noActionOnDelete()->cascadeOnUpdate();
            $table->string('participant');
            $table->string('exam_code');
            $table->string('exam_name');
            $table->decimal('score', 8, 2);
            $table->string('duration')->nullable();
            $table->datetime('attempt_time');
            $table->datetime('end_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_results');
    }
};
