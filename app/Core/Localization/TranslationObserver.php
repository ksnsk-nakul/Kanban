<?php

namespace App\Core\Localization;

use App\Models\Translation;
use Illuminate\Support\Facades\Cache;

final class TranslationObserver
{
    public function saved(Translation $translation): void
    {
        $this->clearLocale($translation->language?->code);
    }

    public function deleted(Translation $translation): void
    {
        $this->clearLocale($translation->language?->code);
    }

    private function clearLocale(?string $locale): void
    {
        if (!$locale) {
            return;
        }

        Cache::forget("devlife.translations.messages.{$locale}");
    }
}

