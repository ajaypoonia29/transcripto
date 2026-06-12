<?php

declare(strict_types=1);

namespace App\Domains\Payments\Actions;

use App\Domains\Payments\Models\PaymentRecord;
use App\Domains\Payments\Tasks\GenerateRazorpayOrderTask;
use App\Domains\Payments\Tasks\LogTransactionLedgerTask;
use App\Domains\Payments\Tasks\CreateGoogleMeetTask;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class InitializeSubscriptionAction
{
    public function __construct(
        protected readonly GenerateRazorpayOrderTask $generateRazorpayOrderTask,
        protected readonly LogTransactionLedgerTask $logTransactionLedgerTask,
        protected readonly CreateGoogleMeetTask $createGoogleMeetTask
    ) {}

    /**
     * Initialize a new subscription or consultation and log it.
     *
     * @param int $userId
     * @param string $pricingPlanId
     * @param string|null $scheduledAt ISO datetime string for consultations
     * @throws InvalidArgumentException
     * @return PaymentRecord
     */
    public function execute(int $userId, string $pricingPlanId, ?string $scheduledAt = null): PaymentRecord
    {
        // Mock pricing plans configuration
        $plans = [
            'basic_monthly' => 99900,     // INR 999.00
            'premium_monthly' => 249900,   // INR 2,499.00
            'elite_annual' => 1999900,    // INR 19,999.00
            'paid_consultation' => 99900,  // INR 999.00 (Paid video call session)
        ];

        if (!array_key_exists($pricingPlanId, $plans)) {
            throw new InvalidArgumentException("Invalid pricing plan ID: {$pricingPlanId}");
        }

        $amount = $plans[$pricingPlanId];

        // Generate Google Meet conference details if this is a paid consultation call
        $meetLink = null;
        if ($pricingPlanId === 'paid_consultation' && $scheduledAt) {
            $meetLink = $this->createGoogleMeetTask->execute(
                "Transcripto Video Consultation - User #{$userId}",
                $scheduledAt
            );
        }

        return DB::transaction(function () use ($userId, $pricingPlanId, $amount, $scheduledAt, $meetLink): PaymentRecord {
            $orderId = $this->generateRazorpayOrderTask->execute($amount);

            return $this->logTransactionLedgerTask->execute([
                'user_id' => $userId,
                'pricing_plan_id' => $pricingPlanId,
                'razorpay_order_id' => $orderId,
                'razorpay_payment_id' => null,
                'amount_paid' => $amount,
                'transaction_status' => 'initiated',
                'scheduled_at' => $scheduledAt,
                'google_meet_link' => $meetLink,
            ]);
        });
    }
}
