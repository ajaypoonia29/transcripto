<?php

declare(strict_types=1);

namespace App\Domains\Coaching\Actions;

use App\Domains\Coaching\Tasks\AssignPlansTask;
use Illuminate\Support\Facades\DB;

class AssignPlansAction
{
    public function __construct(
        protected readonly AssignPlansTask $assignPlansTask
    ) {}

    /**
     * Coordinate assigning new workout and diet plans in a transaction.
     *
     * @param int $userId
     * @param array<int, array{day_of_week: string, exercise_name: string, sets: int, reps: string}> $workouts
     * @param array<int, array{meal_name: string, food_items: string, calories: int}> $diets
     * @return void
     */
    public function execute(int $userId, array $workouts, array $diets): void
    {
        DB::transaction(function () use ($userId, $workouts, $diets) {
            $this->assignPlansTask->execute($userId, $workouts, $diets);
        });
    }
}
