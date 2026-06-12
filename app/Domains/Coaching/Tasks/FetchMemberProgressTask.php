<?php

declare(strict_types=1);

namespace App\Domains\Coaching\Tasks;

use App\Domains\Coaching\Models\WorkoutPlan;
use App\Domains\Coaching\Models\DietPlan;
use App\Domains\Coaching\Models\ProgressLog;

class FetchMemberProgressTask
{
    /**
     * Fetch all workout plans, diet plans, and progress logs for a user.
     *
     * @param int $userId
     * @return array{workouts: \Illuminate\Database\Eloquent\Collection, diets: \Illuminate\Database\Eloquent\Collection, progress_logs: \Illuminate\Database\Eloquent\Collection}
     */
    public function execute(int $userId): array
    {
        $workouts = WorkoutPlan::query()->where('user_id', $userId)->get();
        $diets = DietPlan::query()->where('user_id', $userId)->get();
        $progressLogs = ProgressLog::query()
            ->where('user_id', $userId)
            ->orderBy('log_date', 'asc')
            ->get();

        return [
            'workouts' => $workouts,
            'diets' => $diets,
            'progress_logs' => $progressLogs,
        ];
    }
}
