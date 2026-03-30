<?php

namespace Database\Seeders\DevLife;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguagesSeeder extends Seeder
{
    public function run(): void
    {
        $languages = [
            ['code' => 'en', 'name' => 'English', 'direction' => 'ltr', 'active' => true, 'is_default' => true],
            ['code' => 'fr', 'name' => 'French', 'direction' => 'ltr', 'active' => true, 'is_default' => false],
            ['code' => 'ar', 'name' => 'Arabic', 'direction' => 'rtl', 'active' => true, 'is_default' => false],
            ['code' => 'es', 'name' => 'Spanish', 'direction' => 'ltr', 'active' => true, 'is_default' => false],
            ['code' => 'hi', 'name' => 'Hindi', 'direction' => 'ltr', 'active' => true, 'is_default' => false],
        ];

        foreach ($languages as $language) {
            Language::query()->updateOrCreate(
                ['code' => $language['code']],
                $language,
            );
        }
    }
}

