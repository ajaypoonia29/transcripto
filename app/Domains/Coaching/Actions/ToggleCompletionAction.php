<?php

declare(strict_types=1);

namespace App\Domains\Coaching\Actions;

use App\Domains\Coaching\Tasks\ToggleCompletionTask;
use Illuminate\Support\Facades\DB;

class ToggleCompletionAction
{
    public function __construct(
        protected readonly ToggleCompletionTask $toggleCompletionTask
    ) {}

    /**
     * Coordinate toggling item completion and updating daily progress log.
     *
     * @param int $userId
     * @param string $type
     * @param int $itemId
     * @param bool $isCompleted
     * @return void
     */
    public function execute(int $userId, string $type, int $itemId, bool $isCompleted): void
    {
        DB::transaction(function () use ($userId, $type, $itemId, $isCompleted) {
            $this->toggleCompletionTask->execute($userId, $type, $itemId, $isCompleted);
        });
    }
}
