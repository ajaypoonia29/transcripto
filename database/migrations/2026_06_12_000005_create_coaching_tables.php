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
        Schema::create('workout_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('day_of_week');
            $table->string('exercise_name');
            $table->integer('sets');
            $table->string('reps');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });

        Schema::create('diet_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('meal_name');
            $table->string('food_items');
            $table->integer('calories');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });

        Schema::create('progress_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('log_date');
            $table->decimal('weight', 5, 2)->nullable();
            $table->integer('workout_completed_pct');
            $table->integer('diet_completed_pct');
            $table->timestamps();

            $table->unique(['user_id', 'log_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_logs');
        Schema::dropIfExists('diet_plans');
        Schema::dropIfExists('workout_plans');
    }
};
