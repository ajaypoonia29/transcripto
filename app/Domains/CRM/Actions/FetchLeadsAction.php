<?php

declare(strict_types=1);

namespace App\Domains\CRM\Actions;

use App\Domains\CRM\Models\Lead;
use Illuminate\Database\Eloquent\Collection;

class FetchLeadsAction
{
    /**
     * Fetch all CRM leads.
     *
     * @return Collection<int, Lead>
     */
    public function execute(): Collection
    {
        return Lead::query()->latest()->get();
    }
}
