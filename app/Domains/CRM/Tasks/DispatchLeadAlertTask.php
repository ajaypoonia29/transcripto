<?php

declare(strict_types=1);

namespace App\Domains\CRM\Tasks;

use App\Domains\CRM\Models\Lead;
use App\Domains\CRM\Notifications\LeadAlertNotification;
use Illuminate\Support\Facades\Notification;

class DispatchLeadAlertTask
{
    /**
     * Execute the task to dispatch lead alert notification.
     */
    public function execute(Lead $lead): void
    {
        Notification::route('mail', 'gethelp@transcripto.in')
            ->notify(new LeadAlertNotification($lead));
    }
}
