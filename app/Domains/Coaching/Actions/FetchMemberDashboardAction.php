<?php

declare(strict_types=1);

namespace App\Domains\Coaching\Actions;

use App\Domains\Coaching\Tasks\FetchMemberProgressTask;

class FetchMemberDashboardAction
{
    public function __construct(
        protected readonly FetchMemberProgressTask $fetchMemberProgressTask
    ) {}

    /**
     * Coordinate fetching plans and progress logs for the member dashboard.
     *
     * @param int $userId
     * @return array{workouts: \Illuminate\Database\Eloquent\Collection, diets: \Illuminate\Database\Eloquent\Collection, progress_logs: \Illuminate\Database\Eloquent\Collection}
     */
    public function execute(int $userId): array
    {
        return $this->fetchMemberProgressTask->execute($userId);
    }
}
