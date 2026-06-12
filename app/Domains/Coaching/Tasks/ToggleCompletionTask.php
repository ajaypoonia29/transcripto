<?php

declare(strict_types=1);

namespace App\Domains\Coaching\Tasks;

use App\Domains\Coaching\Models\WorkoutPlan;
use App\Domains\Coaching\Models\DietPlan;
use App\Domains\Coaching\Models\ProgressLog;
use Carbon\Carbon;

class ToggleCompletionTask
{
    /**
     * Toggle the completion of a workout or diet plan item, and update the daily progress log.
     *
     * @param int $userId
     * @param string $type ('workout' | 'diet')
     * @param int $itemId
     * @param bool $isCompleted
     * @return void
     */
    public function execute(int $userId, string $type, int $itemId, bool $isCompleted): void
    {
        if ($type === 'workout') {
            $item = WorkoutPlan::query()->where('user_id', $userId)->findOrFail($itemId);
            $item->update(['is_completed' => $isCompleted]);
        } elseif ($type === 'diet') {
            $item = DietPlan::query()->where('user_id', $userId)->findOrFail($itemId);
            $item->update(['is_completed' => $isCompleted]);
        }

        // Now calculate new completion percentages
        $totalWorkouts = WorkoutPlan::query()->where('user_id', $userId)->count();
        $completedWorkouts = WorkoutPlan::query()->where('user_id', $userId)->where('is_completed', true)->count();
        $workoutPct = $totalWorkouts > 0 ? (int) round(($completedWorkouts / $totalWorkouts) * 100) : 0;

        $totalDiets = DietPlan::query()->where('user_id', $userId)->count();
        $completedDiets = DietPlan::query()->where('user_id', $userId)->where('is_completed', true)->count();
        $dietPct = $totalDiets > 0 ? (int) round(($completedDiets / $totalDiets) * 100) : 0;

        // Update or create today's progress log
        $today = Carbon::today()->toDateString();
        ProgressLog::query()->updateOrCreate(
            ['user_id' => $userId, 'log_date' => $today],
            [
                'workout_completed_pct' => $workoutPct,
                'diet_completed_pct' => $dietPct,
            ]
        );
    }
}
