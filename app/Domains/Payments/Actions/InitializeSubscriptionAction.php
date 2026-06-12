<?php

declare(strict_types=1);

namespace App\Domains\Payments\Actions;

use App\Domains\Payments\Models\PaymentRecord;
use App\Domains\Payments\Tasks\GenerateRazorpayOrderTask;
use App\Domains\Payments\Tasks\LogTransactionLedgerTask;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InitializeSubscriptionAction
{
    public function __construct(
        protected readonly GenerateRazorpayOrderTask $generateRazorpayOrderTask,
        protected readonly LogTransactionLedgerTask $logTransactionLedgerTask
    ) {}

    /**
     * Initialize a new subscription and log it.
     *
     * @param int $userId
     * @param string $pricingPlanId
     * @throws InvalidArgumentException
     * @return PaymentRecord
     */
    public function execute(int $userId, string $pricingPlanId): PaymentRecord
    {
        // Mock pricing plans configuration
        $plans = [
            'basic_monthly' => 99900,    // INR 999.00
            'premium_monthly' => 249900,  // INR 2,499.00
            'elite_annual' => 1999900,   // INR 19,999.00
        ];

        if (!array_key_exists($pricingPlanId, $plans)) {
            throw new InvalidArgumentException("Invalid pricing plan ID: {$pricingPlanId}");
        }

        $amount = $plans[$pricingPlanId];

        return DB::transaction(function () use ($userId, $pricingPlanId, $amount): PaymentRecord {
            $orderId = $this->generateRazorpayOrderTask->execute($amount);

            return $this->logTransactionLedgerTask->execute([
                'user_id' => $userId,
                'pricing_plan_id' => $pricingPlanId,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => null,
                'amount_paid' => $amount,
                'transaction_status' => 'initiated',
            ]);
        });
    }
}
