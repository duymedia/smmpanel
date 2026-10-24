<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponUsage extends Model
{
    protected $fillable = [
        'coupon_id',
        'user_id',
        'item_type',
        'item_id',
        'discount_value',
        'domain',
    ];

    protected $casts = [
        'coupon_id'      => 'integer',
        'user_id'        => 'integer',
        'item_id'        => 'integer',
        'discount_value' => 'decimal:4',
    ];

    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    public function account(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
