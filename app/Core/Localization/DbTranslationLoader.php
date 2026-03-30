<?php

namespace App\Core\Localization;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Cache;
use Illuminate\Translation\FileLoader;

final class DbTranslationLoader extends FileLoader
{
    public function __construct(Filesystem $files, string $path)
    {
        parent::__construct($files, $path);
    }

    public function load($locale, $group, $namespace = null): array
    {
        $lines = parent::load($locale, $group, $namespace);

        // JSON translations: __('Login') resolves via group="*", namespace="*"
        if ($group === '*' && $namespace === '*') {
            return array_replace($lines, $this->loadDbJson((string) $locale));
        }

        // Optional: allow DB overrides for the default "messages" group as well
        if ($namespace === null && $group === 'messages') {
            return array_replace($lines, $this->loadDbMessages((string) $locale));
        }

        return $lines;
    }

    /**
     * @return array<string, string>
     */
    private function loadDbMessages(string $locale): array
    {
        return Cache::rememberForever("devlife.translations.messages.{$locale}", function () use ($locale): array {
            $languageId = Language::query()->where('code', $locale)->value('id');
            if (!$languageId) {
                return [];
            }

            return Translation::query()
                ->where('language_id', $languageId)
                ->pluck('value', 'key')
                ->all();
        });
    }

    /**
     * @return array<string, string>
     */
    private function loadDbJson(string $locale): array
    {
        return Cache::rememberForever("devlife.translations.json.{$locale}", function () use ($locale): array {
            $languageId = Language::query()->where('code', $locale)->value('id');
            if (!$languageId) {
                return [];
            }

            return Translation::query()
                ->where('language_id', $languageId)
                ->pluck('value', 'key')
                ->all();
        });
    }
}
