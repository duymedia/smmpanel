<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'usage_limit',
        'usage_per_account',
        'used_count',
        'start_date',
        'end_date',
        'account_role',
        'item_type',
        'min_order',
        'note',
        'status',
        'domain',
    ];

    protected $casts = [
        'discount_value'    => 'decimal:4',
        'usage_limit'       => 'integer',
        'usage_per_account' => 'integer',
        'used_count'        => 'integer',
        'start_date'        => 'datetime',
        'end_date'          => 'datetime',
        'account_role'      => 'array',
        'min_order'         => 'decimal:4',
        'status'            => 'boolean',
    ];

    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    public function getIsActiveAttribute(): bool
    {
        $now = now();
        return $this->status
            && $this->start_date <= $now
            && $this->end_date >= $now
            && (is_null($this->usage_limit) || $this->used_count < $this->usage_limit);
    }
}
