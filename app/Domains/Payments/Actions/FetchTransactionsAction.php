<?php

declare(strict_types=1);

namespace App\Domains\Payments\Actions;

use App\Domains\Payments\Models\PaymentRecord;
use Illuminate\Database\Eloquent\Collection;

class FetchTransactionsAction
{
    /**
     * Fetch all transaction ledger history.
     *
     * @return Collection<int, PaymentRecord>
     */
    public function execute(): Collection
    {
        return PaymentRecord::query()->latest()->get();
    }
}
