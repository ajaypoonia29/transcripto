<?php

declare(strict_types=1);

namespace App\Domains\CRM\Tasks;

use App\Domains\CRM\Models\Lead;

class CreateLeadTask
{
    /**
     * Execute the task to create a new Lead.
     *
     * @param array{full_name: string, email_address: string, phone_number: string, pipeline_status: string, preferred_program_type: string} $data
     * @return Lead
     */
    public function execute(array $data): Lead
    {
        /** @var Lead */
        return Lead::query()->create($data);
    }
}
