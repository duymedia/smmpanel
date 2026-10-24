<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Language;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $domain = getDomain();

        $languages = [
            ['code' => 'vi', 'name' => 'Tiếng Việt', 'flag' => 'fi fi-vn', 'status' => true],
            ['code' => 'en', 'name' => 'English',    'flag' => 'fi fi-us', 'status' => true],
        ];

        foreach ($languages as $lang) {
            Language::firstOrCreate(
                ['code' => $lang['code'], 'domain' => $domain],
                ['name' => $lang['name'], 'flag' => $lang['flag'], 'status' => $lang['status'], 'domain' => $domain]
            );
        }
    }
}
