<?php

declare(strict_types=1);

namespace App\Domains\Payments\Tasks;

use App\Domains\Payments\Models\PaymentRecord;

class LogTransactionLedgerTask
{
    /**
     * Log or update a transaction record in the ledger.
     *
     * @param array{
     *     user_id: int,
     *     pricing_plan_id: string,
     *     razorpay_order_id: string,
     *     razorpay_payment_id?: string|null,
     *     amount_paid: int,
     *     transaction_status: string
     * } $data
     * @return PaymentRecord
     */
    public function execute(array $data): PaymentRecord
    {
        /** @var PaymentRecord */
        return PaymentRecord::query()->updateOrCreate(
            ['razorpay_order_id' => $data['razorpay_order_id']],
            $data
        );
    }
}
