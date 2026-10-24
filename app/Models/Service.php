<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id', 'name', 'title', 'description', 'image', 'position',
        'rate_retail', 'rate_agent', 'rate_distributor', 
        'rate_original', 'rate_retail_up', 'rate_agent_up', 'rate_distributor_up',
        'min', 'max', 'overflow', 'service_api', 'provider_id', 'provider_name',
        'type', 'type_service', 'type_radio', 'refill', 'cancel', 'dripfeed', 
        'sync_rate', 'sync_min_max', 'sync_refill', 'sync_cancel', 'sync_status',
        'average_time', 'note', 'reaction', 'attributes',
        'status', 'domain', 'quantity_discount', 'quantity_discount_data',
        'advanced_settings', 'advanced_settings_data', 'check_count',
        'check_count_data', 'hidden_api', 'change_provider', 'summaries'
    ];
    
    protected $casts = [
        'name' => 'json',
        'position' => 'integer',
        'rate_retail' => 'decimal:8',
        'rate_agent' => 'decimal:8',
        'rate_distributor' => 'decimal:8',
        'rate_original' => 'decimal:8',
        'rate_retail_up' => 'decimal:2',
        'rate_agent_up' => 'decimal:2',
        'rate_distributor_up' => 'decimal:2',
        'refill' => 'boolean', 
        'cancel' => 'boolean', 
        'dripfeed' => 'boolean', 
        'sync_rate' => 'boolean',
        'sync_min_max' => 'boolean',
        'sync_refill' => 'boolean',
        'sync_cancel' => 'boolean',
        'sync_status' => 'boolean',
        'status' => 'boolean',
        'overflow' => 'integer',
        'quantity_discount' => 'boolean',
        'quantity_discount_data' => 'array',
        'advanced_settings' => 'boolean',
        'advanced_settings_data' => 'array',
        'check_count' => 'boolean',
        'check_count_data' => 'array',
        'hidden_api' => 'boolean',
        'change_provider' => 'boolean',
        'summaries' => 'array',
        'attributes' => 'array'
    ];
    public function category() 
    { 
        return $this->belongsTo(Category::class); 
    }

    public function provider() 
    { 
        return $this->belongsTo(ApiProvider::class, 'provider_id'); 
    }

    public function orders() 
    { 
        return $this->hasMany(Order::class); 
    }
    public function getName(?string $lang = null): string
    {
        $lang = $lang ?? (auth()->check() ? auth()->user()->lang : 'en');
        $name = $this->name;
        $value = is_array($name)
            ? ($name[$lang] ?? $name['en'] ?? reset($name) ?? 'Unnamed')
            : ($name ?? 'Unnamed');
        return trim((string) $value);
    }
    public function getTitle(?string $lang = null): string
    {
        $lang = $lang ?? (auth()->check() ? auth()->user()->lang : 'en');
        $title = $this->title;
        return is_array($title) ? ($title[$lang] ?? $title['en'] ?? reset($title) ?? '') : ($title ?? '');
    }
    public function getDescription(?string $lang = null): string
    {
        $lang = $lang ?? (auth()->check() ? auth()->user()->lang : 'en');
        $desc = $this->description;
        return is_array($desc) ? ($desc[$lang] ?? $desc['en'] ?? reset($desc) ?? '') : ($desc ?? '');
    }
    public function getLocalized(string $field, ?string $lang = null, string $default = ''): string
    {
        $lang = $lang ?? (auth()->check() ? auth()->user()->lang : 'en');
        $data = $this->{$field};
        return is_array($data) ? ($data[$lang] ?? $data['en'] ?? reset($data) ?? $default) : ($data ?? $default);
    }
    public function getRateAttribute()
    {
        return $this->rate_retail;
    }

    public function getRateFormattedAttribute()
    {
        return '$' . number_format($this->rate_retail, 4) . ' per 1000';
    }
    public function scopeActive($query) 
    { 
        return $query->where('status', true); 
    }

    public function scopeOrdered($query) 
    { 
        return $query->orderBy('position', 'asc'); 
    }
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($service) {
            if (!$service->position) {
                $service->position = static::where('category_id', $service->category_id)->max('position') + 1;
            }
            if (is_null($service->attributes)) {
                $service->attributes = [];
            }
        });
        
        static::updating(function ($service) {
            if (is_null($service->attributes)) {
                $service->attributes = [];
            }
        });
        

    }
    protected function setAttributesAttribute($value)
    {
        if (is_null($value)) {
            $this->attributes['attributes'] = null;
            return;
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                $this->attributes['attributes'] = json_encode($decoded);
                return;
            }
            $this->attributes['attributes'] = json_encode([]);
            return;
        }
        
        if (is_array($value)) {
            $this->attributes['attributes'] = json_encode($value);
            return;
        }
        $this->attributes['attributes'] = json_encode([]);
    }
    protected function getAttributesAttribute($value)
    {
        if (is_null($value)) {
            return [];
        }
        
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return $decoded;
            }
            return [];
        }
        
        if (is_array($value)) {
            return $value;
        }
        
        return [];
    }
}
