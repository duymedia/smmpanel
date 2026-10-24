<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['name', 'code', 'flag', 'status', 'domain'];
    protected $casts = ['status' => 'boolean'];

    /**
     * _settings.fn.templateCountry tự thêm tiền tố `fi fi-` cho data-icon.
     * Database vẫn lưu nguyên class flag, ví dụ `fi fi-mw`.
     */
    public function getFlagCodeAttribute(): string
    {
        return preg_replace('/^fi\s+fi-/', '', (string) $this->flag);
    }
}
