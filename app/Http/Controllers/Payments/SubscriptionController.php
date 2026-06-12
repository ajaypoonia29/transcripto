<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payments;

use App\Domains\Payments\Actions\InitializeSubscriptionAction;
use App\Domains\Payments\Actions\FetchTransactionsAction;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscriptionController extends Controller
{
    public function __construct(
        protected readonly InitializeSubscriptionAction $initializeSubscriptionAction,
        protected readonly FetchTransactionsAction $fetchTransactionsAction
    ) {}

    /**
     * Display a listing of transaction ledgers.
     */
    public function index(): JsonResponse
    {
        $transactions = $this->fetchTransactionsAction->execute();

        return response()->json([
            'success' => true,
            'data' => $transactions,
        ], Response::HTTP_OK);
    }

    /**
     * Initialize a new subscription.
     */
    public function initialize(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'integer'],
            'pricing_plan_id' => ['required', 'string', 'in:basic_monthly,premium_monthly,elite_annual'],
        ]);

        $paymentRecord = $this->initializeSubscriptionAction->execute(
            (int) $validated['user_id'],
            (string) $validated['pricing_plan_id']
        );

        return response()->json([
            'success' => true,
            'message' => 'Subscription successfully initialized.',
            'data' => [
                'id' => $paymentRecord->id,
                'user_id' => $paymentRecord->user_id,
                'pricing_plan_id' => $paymentRecord->pricing_plan_id,
                'razorpay_order_id' => $paymentRecord->razorpay_order_id,
                'amount_paid' => $paymentRecord->amount_paid,
                'transaction_status' => $paymentRecord->transaction_status,
            ],
        ], Response::HTTP_CREATED);
    }
}
