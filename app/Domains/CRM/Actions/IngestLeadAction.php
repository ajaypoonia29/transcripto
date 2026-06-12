<?php

declare(strict_types=1);

namespace App\Domains\CRM\Actions;

use App\Domains\CRM\Models\Lead;
use App\Domains\CRM\Tasks\CreateLeadTask;
use App\Domains\CRM\Tasks\DispatchLeadAlertTask;
use Illuminate\Support\Facades\DB;

class IngestLeadAction
{
    public function __construct(
        protected readonly CreateLeadTask $createLeadTask,
        protected readonly DispatchLeadAlertTask $dispatchLeadAlertTask
    ) {}

    /**
     * Ingest a new lead and alert the team.
     *
     * @param array{full_name: string, email_address: string, phone_number: string, pipeline_status: string, preferred_program_type: string} $data
     * @return Lead
     */
    public function execute(array $data): Lead
    {
        return DB::transaction(function () use ($data): Lead {
            $lead = $this->createLeadTask->execute($data);
            $this->dispatchLeadAlertTask->execute($lead);

            return $lead;
        });
    }
}
