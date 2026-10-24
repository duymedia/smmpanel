<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethodGroup extends Model
{
    protected $fillable = [
        'name',
        'methods',
        'position',
        'status',
        'domain',
    ];

    protected $casts = [
        'methods' => 'array',
        'status' => 'boolean',
        'position' => 'integer',
    ];

    public function paymentMethods()
    {
        $ids = $this->methods ?? [];
        return PaymentMethod::whereIn('id', $ids)->get();
    }
}
