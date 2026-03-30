<?php

namespace App\Http\Controllers\Admin;

use App\Core\Settings\SettingsManager;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Setting;
use App\Models\SettingsGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

final class LanguageController extends Controller
{
    public function index(): View
    {
        $languages = Language::query()
            ->orderByDesc('is_default')
            ->orderByDesc('active')
            ->orderBy('name')
            ->get();

        return view('admin.languages.index', [
            'languages' => $languages,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:10', 'alpha_dash', 'unique:languages,code'],
            'name' => ['required', 'string', 'max:80'],
            'direction' => ['required', Rule::in(['ltr', 'rtl'])],
        ]);

        Language::query()->create([
            'code' => strtolower($data['code']),
            'name' => $data['name'],
            'direction' => $data['direction'],
            'active' => false,
            'is_default' => false,
        ]);

        return back();
    }

    public function update(Request $request, Language $language): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'direction' => ['required', Rule::in(['ltr', 'rtl'])],
        ]);

        $language->update([
            'name' => $data['name'],
            'direction' => $data['direction'],
        ]);

        return back();
    }

    public function toggle(Request $request, Language $language): RedirectResponse
    {
        if ($language->active && Language::query()->where('active', true)->count() <= 1) {
            return back()->withErrors(['language' => __('At least one language must remain active.')]);
        }

        $language->active = !$language->active;

        if (!$language->active && $language->is_default) {
            $language->is_default = false;
        }

        $language->save();

        return back();
    }

    public function setDefault(Request $request, Language $language, SettingsManager $settings): RedirectResponse
    {
        DB::transaction(function () use ($language) {
            Language::query()->update(['is_default' => false]);
            $language->active = true;
            $language->is_default = true;
            $language->save();
        });

        // Keep middleware fallback stable even if buyers prefer settings-based reads.
        $groupId = SettingsGroup::query()->where('key', 'general')->value('id');
        if ($groupId) {
            Setting::query()->updateOrCreate(
                ['settings_group_id' => $groupId, 'key' => 'default_language'],
                ['value' => $language->code, 'type' => 'string', 'is_public' => false, 'is_encrypted' => false],
            );
        }

        $settings->clearCache();

        return back();
    }
}
