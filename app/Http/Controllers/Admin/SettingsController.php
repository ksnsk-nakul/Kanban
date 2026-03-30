<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Core\Settings\SettingsManager;
use App\Models\Setting;
use App\Models\SettingsGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
        ]);
    }

    public function update(Request $request, SettingsManager $settings): RedirectResponse
    {
        $data = $request->validate([
            'settings' => ['required', 'array'],
        ]);

        foreach ($data['settings'] as $settingId => $value) {
            if (!is_numeric($settingId)) {
                continue;
            }

            $setting = Setting::query()->find((int) $settingId);
            if (!$setting) {
                continue;
            }

            $setting->value = is_array($value) ? json_encode($value) : (string) $value;
            $setting->save();
        }

        $settings->clearCache();

        return back();
    }
}
