<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCustomRate extends Model
{
    protected $fillable = [
        'user_id',
        'service_id',
        'rate',
        'percent',
        'domain',
    ];

    protected $casts = [
        'rate'    => 'float',
        'percent' => 'float',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
