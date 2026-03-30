<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuthMethod;
use App\Models\Setting;
use App\Models\SettingsGroup;
use App\Core\Settings\SettingsManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class AuthMethodController extends Controller
{
    public function index(): View
    {
        $methods = AuthMethod::query()
            ->orderBy('sort_order')
            ->orderBy('key')
            ->get();

        return view('admin.auth-methods.index', [
            'methods' => $methods,
        ]);
    }

    public function toggle(Request $request, AuthMethod $authMethod, SettingsManager $settings): RedirectResponse
    {
        if ($authMethod->enabled && AuthMethod::query()->where('enabled', true)->count() <= 1) {
            return back()->withErrors(['auth' => __('At least one authentication method must remain enabled.')]);
        }

        $authMethod->enabled = !$authMethod->enabled;
        $authMethod->save();

        $authGroupId = SettingsGroup::query()->where('key', 'auth')->value('id');
        if ($authGroupId) {
            $enabled = AuthMethod::query()
                ->where('enabled', true)
                ->orderBy('sort_order')
                ->pluck('key')
                ->values()
                ->all();

            Setting::query()->updateOrCreate(
                ['settings_group_id' => $authGroupId, 'key' => 'enabled_methods'],
                ['value' => json_encode($enabled), 'type' => 'json', 'is_public' => false, 'is_encrypted' => false],
            );
        }

        $settings->clearCache();

        return back();
    }
}
