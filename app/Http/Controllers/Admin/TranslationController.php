<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Translation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class TranslationController
{
    public function index(Request $request): View
    {
        $languages = Language::query()
            ->where('active', true)
            ->orderByDesc('is_default')
            ->orderBy('name')
            ->get();

        $lang = (string) $request->query('lang', '');
        $language = $lang !== ''
            ? $languages->firstWhere('code', $lang)
            : $languages->firstWhere('is_default', true);

        $language ??= $languages->first();

        $q = trim((string) $request->query('q', ''));

        $translations = Translation::query()
            ->when($language, fn ($query) => $query->where('language_id', $language->id))
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('key', 'like', "%{$q}%")
                        ->orWhere('value', 'like', "%{$q}%");
                });
            })
            ->orderBy('key')
            ->paginate(50)
            ->withQueryString();

        return view('admin.translations.index', [
            'languages' => $languages,
            'language' => $language,
            'translations' => $translations,
            'q' => $q,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'language_id' => ['required', 'integer', 'exists:languages,id'],
            'key' => ['required', 'string', 'max:180'],
            'value' => ['required', 'string'],
        ]);

        Translation::query()->updateOrCreate(
            ['language_id' => $data['language_id'], 'key' => $data['key']],
            ['value' => $data['value']],
        );

        return back();
    }

    public function update(Request $request, Translation $translation): RedirectResponse
    {
        $data = $request->validate([
            'value' => ['required', 'string'],
        ]);

        $translation->value = $data['value'];
        $translation->save();

        return back();
    }

    public function destroy(Request $request, Translation $translation): RedirectResponse
    {
        $translation->delete();

        return back();
    }
}
