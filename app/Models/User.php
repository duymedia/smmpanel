<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ROLE_RETAIL = 0;
    public const ROLE_ADMIN = 1;
    public const ROLE_AGENT = 4;
    public const ROLE_DISTRIBUTOR = 5;
    public const ROLE_STAFF = 6;

    public const ROLE_LABELS = [
        self::ROLE_RETAIL => 'Khách lẻ',
        self::ROLE_ADMIN => 'Admin',
        self::ROLE_STAFF => 'Nhân viên',
        self::ROLE_AGENT => 'Đại lý',
        self::ROLE_DISTRIBUTOR => 'Nhà phân phối',
    ];

    protected $fillable = ['name', 'username', 'email', 'phone', 'password', 'balance','spent', 'api_key', 'is_active', 'timezone', 'lang','currency', 'role', 'transfer_code', 'referral_code', 'two_factor_enabled', 'two_factor_secret', 'two_factor_recovery_codes', 'domain', 'percent_bonus'];
    protected $hidden = ['password', 'remember_token', 'two_factor_secret', 'two_factor_recovery_codes'];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'balance' => 'decimal:8',
        'spent' => 'decimal:8',
        'percent_bonus' => 'integer',
        'role' => 'integer',
        'is_active' => 'boolean',
        'two_factor_enabled' => 'boolean',
        'two_factor_confirmed_at' => 'datetime',
        'two_factor_recovery_codes' => 'json',
    ];

    /**
     * Appended attributes for API responses and serialization
     */
    protected $appends = ['bonus_percent_formatted', 'bonus_is_active', 'bonus_display', 'bonus_level'];

    // Relationships
    public function orders() { return $this->hasMany(Order::class); }
    public function transactions() { return $this->hasMany(Transaction::class); }
    public function tickets() { return $this->hasMany(Ticket::class); }
    public function referrals() { return $this->hasMany(Affiliate::class, 'referrer_id'); }
    public function referredBy() { return $this->hasOne(Affiliate::class, 'referred_id'); }

    // Helpers
    public function isRetail() { return $this->role === self::ROLE_RETAIL; }
    public function isAgent() { return $this->role === self::ROLE_AGENT; }
    public function isDistributor() { return $this->role === self::ROLE_DISTRIBUTOR; }
    public function isStaff() { return $this->role === self::ROLE_STAFF; }
    public function isUser() { return $this->role !== self::ROLE_ADMIN; }
    public function isAdmin(): bool { return $this->role === self::ROLE_ADMIN; }
    public function getRoleLabelAttribute(): string { return self::ROLE_LABELS[$this->role] ?? 'Không xác định'; }
    public function hasTwoFactorEnabled() { return $this->two_factor_enabled && !is_null($this->two_factor_secret); }

    /**
     * Accessor: Get formatted integer bonus value.
     */
    public function getBonusPercentFormattedAttribute(): string
    {
        return number_format((int) ($this->percent_bonus ?? 0));
    }

    /**
     * Accessor: Check if bonus is active (> 0)
     */
    public function getBonusIsActiveAttribute(): bool
    {
        return (int) ($this->percent_bonus ?? 0) > 0;
    }

    /**
     * Accessor: Get display format with percent sign
     */
    public function getBonusDisplayAttribute(): string
    {
        $formatted = number_format((int) ($this->percent_bonus ?? 0));
        return $formatted . '%';
    }

    /**
     * Accessor: Get bonus level classification (none|low|medium|high)
     */
    public function getBonusLevelAttribute(): string
    {
        $percent = (int) ($this->percent_bonus ?? 0);

        if ($percent <= 0) return 'none';
        if ($percent < 10) return 'low';
        if ($percent < 50) return 'medium';
        return 'high';
    }

    // Scopes
    public function scopeByRole($query, $role) { return $query->where('role', $role); }
}
