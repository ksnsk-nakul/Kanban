<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Core\Settings\SettingDefinitions;
use App\Core\Settings\SettingsManager;
use App\Models\Setting;
use App\Models\SettingsGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $groups = SettingsGroup::query()
            ->with('settings')
            ->orderBy('sort_order')
            ->get();

        return view('admin.settings.index', [
            'groups' => $groups,
            'definitions' => SettingDefinitions::all(),
        ]);
    }

    public function update(Request $request, SettingsManager $settings): RedirectResponse
    {
        $data = $request->validate([
            'settings' => ['nullable', 'array'],
            'files' => ['nullable', 'array'],
            'files.*' => ['file', 'max:3072'],
        ]);

        $plainSettings = $data['settings'] ?? [];

        foreach ($plainSettings as $settingId => $value) {
            if (!is_numeric($settingId)) {
                continue;
            }

            $setting = Setting::query()->find((int) $settingId);
            if (!$setting) {
                continue;
            }

            if ($setting->is_encrypted) {
                $v = is_array($value) ? json_encode($value) : (string) $value;
                $v = trim($v);
                if ($v === '') {
                    continue;
                }

                $setting->value = Crypt::encryptString($v);
                $setting->save();
                continue;
            }

            if ($setting->type === 'bool') {
                $setting->value = filter_var($value, FILTER_VALIDATE_BOOL) ? 'true' : 'false';
                $setting->save();
                continue;
            }

            if ($setting->type === 'json') {
                if (is_array($value)) {
                    $setting->value = json_encode($value);
                } else {
                    $decoded = json_decode((string) $value, true);
                    $setting->value = is_array($decoded) ? json_encode($decoded) : json_encode([]);
                }
                $setting->save();
                continue;
            }

            $setting->value = is_array($value) ? json_encode($value) : (string) $value;
            $setting->save();
        }

        $files = $request->file('files', []);
        if (is_array($files)) {
            foreach ($files as $settingId => $file) {
                if (!is_numeric($settingId) || !$file) {
                    continue;
                }

                $setting = Setting::query()->find((int) $settingId);
                if (!$setting) {
                    continue;
                }

                $path = $file->store('branding', 'public');
                $setting->value = $path;
                $setting->save();
            }
        }

        $settings->clearCache();

        return back();
    }
}
