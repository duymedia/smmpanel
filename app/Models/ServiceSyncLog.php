<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceSyncLog extends Model
{
    protected $fillable = [
        'service_id', 'provider_id', 'provider_name', 'service_api',
        'change_type', 'old_value', 'new_value', 'field_changed',
        'is_read', 'domain', 'log_type', 'changes', 'sync_batch',
    ];

    protected $casts = [
        'is_read'   => 'boolean',
        'old_value' => 'float',
        'new_value' => 'float',
        'changes'   => 'array',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function provider()
    {
        return $this->belongsTo(ApiProvider::class, 'provider_id');
    }

    /**
     * Scope: chỉ lấy log của domain hiện tại
     */
    public function scopeForDomain($query)
    {
        return $query->where('domain', getDomain());
    }

    // type = 'website': hiển thị cho người dùng
    public function scopeWebsite($query)
    {
        return $query->where('type', 'website');
    }

    // type = 'api': dữ liệu đồng bộ từ API
    public function scopeApi($query)
    {
        return $query->where('type', 'api');
    }

    /**
     * Scope: chưa đọc
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Đánh dấu tất cả đã đọc
     */
    public static function markAllRead(string $domain): int
    {
        return static::where('domain', $domain)
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }
}
