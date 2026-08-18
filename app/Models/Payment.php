<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class Payment extends Model
{
    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'payment_method_id',
        'transaction_id',
        'amount',
        'bonus_amount',
        'total_amount',
        'currency',
        'exchange_rate',
        'status',
        'payment_info',
        'domain',
        'binance_order_id',
        'binance_transaction_id',
        'binance_amount',
        'binance_asset',
        'binance_payee_id',
        'binance_status',
        'binance_timestamp',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'bonus_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'exchange_rate' => 'decimal:4',
        'payment_info' => 'array',
        'binance_amount' => 'decimal:8',
        'binance_timestamp' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where('status', 'completed');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->where('status', 'pending');
    }

    public function scopeByStatus(Builder $query, $status): Builder
    {
        return $query->where('status', $status);
    }

    public function scopeByPaymentMethod(Builder $query, $methodId): Builder
    {
        return $query->where('payment_method_id', $methodId);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeSearch(Builder $query, string $search): Builder
    {
        if (empty(trim($search))) {
            return $query;
        }

        return $query->where(function ($q) use ($search) {
            $q->where('transaction_id', 'like', "%{$search}%")
                ->orWhere('note', 'like', "%{$search}%");
        });
    }

    // Binance-specific scopes
    public function scopeByBinanceOrderId(Builder $query, string $orderId): Builder
    {
        return $query->where('binance_order_id', $orderId);
    }

    public function scopeByBinanceTransactionId(Builder $query, string $txnId): Builder
    {
        return $query->where('binance_transaction_id', $txnId);
    }

    public function scopeBinancePayments(Builder $query): Builder
    {
        return $query->whereNotNull('binance_order_id');
    }

    // Binance-specific methods
    public function isBinancePayment(): bool
    {
        return !empty($this->binance_order_id);
    }

    public function getBinanceInfo(): array
    {
        return [
            'order_id' => $this->binance_order_id,
            'transaction_id' => $this->binance_transaction_id,
            'amount' => $this->binance_amount,
            'asset' => $this->binance_asset,
            'payee_id' => $this->binance_payee_id,
            'status' => $this->binance_status,
            'timestamp' => $this->binance_timestamp,
        ];
    }
}
