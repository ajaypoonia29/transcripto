<?php

declare(strict_types=1);

namespace App\Domains\CRM\Actions;

use App\Domains\CRM\Models\Lead;

class UpdateLeadAction
{
    /**
     * Update an existing lead pipeline status or details.
     *
     * @param int $id
     * @param array{pipeline_status?: string, full_name?: string, email_address?: string, phone_number?: string, preferred_program_type?: string} $data
     * @return Lead
     */
    public function execute(int $id, array $data): Lead
    {
        /** @var Lead $lead */
        $lead = Lead::query()->findOrFail($id);
        $lead->update($data);
        return $lead;
    }
}
