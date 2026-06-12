<?php

declare(strict_types=1);

namespace App\Domains\Coaching\Tasks;

use App\Domains\Coaching\Models\WorkoutPlan;
use App\Domains\Coaching\Models\DietPlan;

class AssignPlansTask
{
    /**
     * Assign weekly workout and diet plans to a user.
     *
     * @param int $userId
     * @param array<int, array{day_of_week: string, exercise_name: string, sets: int, reps: string}> $workouts
     * @param array<int, array{meal_name: string, food_items: string, calories: int}> $diets
     * @return void
     */
    public function execute(int $userId, array $workouts, array $diets): void
    {
        // Delete existing workout plans
        WorkoutPlan::query()->where('user_id', $userId)->delete();

        // Insert new workout plans
        foreach ($workouts as $workout) {
            WorkoutPlan::query()->create([
                'user_id' => $userId,
                'day_of_week' => $workout['day_of_week'],
                'exercise_name' => $workout['exercise_name'],
                'sets' => $workout['sets'],
                'reps' => $workout['reps'],
                'is_completed' => false,
            ]);
        }

        // Delete existing diet plans
        DietPlan::query()->where('user_id', $userId)->delete();

        // Insert new diet plans
        foreach ($diets as $diet) {
            DietPlan::query()->create([
                'user_id' => $userId,
                'meal_name' => $diet['meal_name'],
                'food_items' => $diet['food_items'],
                'calories' => $diet['calories'],
                'is_completed' => false,
            ]);
        }
    }
}
