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
        $flagCode = preg_replace('/^(?:fi\s+)?fi-/', '', trim((string) $this->flag));
        if ($flagCode !== '') {
            return $flagCode;
        }

        $languageCode = strtolower((string) $this->code);
        return $languageCode === 'vi' ? 'vn' : $languageCode;
    }
}
