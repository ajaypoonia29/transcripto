<?php

declare(strict_types=1);

namespace App\Domains\Payments\Tasks;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GenerateRazorpayOrderTask
{
    /**
     * Generate a Razorpay order.
     *
     * @param int $amount In paise/cents (e.g., 299900 for 2999 INR)
     * @param string $currency
     * @return string The generated razorpay order_id
     */
    public function execute(int $amount, string $currency = 'INR'): string
    {
        $mockOrderId = 'order_' . Str::random(14);

        // Fake the endpoint call for mock execution
        Http::fake([
            'api.razorpay.com/v1/orders' => Http::response([
                'id' => $mockOrderId,
                'entity' => 'order',
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'created',
            ], 200)
        ]);

        $response = Http::post('https://api.razorpay.com/v1/orders', [
            'amount' => $amount,
            'currency' => $currency,
        ]);

        /** @var string */
        return $response->json('id') ?? $mockOrderId;
    }
}
