<?php

declare(strict_types=1);

namespace App\Domains\Payments\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property string $pricing_plan_id
 * @property string $razorpay_order_id
 * @property string|null $razorpay_payment_id
 * @property int $amount_paid
 * @property string $transaction_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class PaymentRecord extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'payment_records';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'pricing_plan_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'amount_paid',
        'transaction_status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'user_id' => 'integer',
            'amount_paid' => 'integer',
            'transaction_status' => 'string',
        ];
    }
}
