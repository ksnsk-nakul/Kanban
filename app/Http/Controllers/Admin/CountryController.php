<?php

namespace App\Http\Controllers\Admin;

use App\Core\Settings\SettingsManager;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

final class CountryController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $countries = Country::query()
            ->when($q !== '', fn ($query) => $query->where('name', 'like', "%{$q}%")->orWhere('iso2', 'like', "%{$q}%"))
            ->orderByDesc('is_default')
            ->orderByDesc('active')
            ->orderBy('name')
            ->paginate(40)
            ->withQueryString();

        $currencies = Currency::query()->orderBy('code')->get();

        return view('admin.countries.index', [
            'countries' => $countries,
            'currencies' => $currencies,
            'q' => $q,
        ]);
    }

    public function update(Request $request, Country $country): RedirectResponse
    {
        $data = $request->validate([
            'currency_code' => ['nullable', 'string', 'size:3', Rule::exists('currencies', 'code')],
        ]);

        $country->currency_code = $data['currency_code'] ?: null;
        $country->save();

        return back();
    }

    public function toggle(Request $request, Country $country): RedirectResponse
    {
        if ($country->active && Country::query()->where('active', true)->count() <= 1) {
            return back()->withErrors(['country' => __('At least one country must remain active.')]);
        }

        if ($country->is_default && $country->active) {
            return back()->withErrors(['country' => __('Default country cannot be disabled. Set another default first.')]);
        }

        $country->active = !$country->active;
        $country->save();

        return back();
    }

    public function setDefault(Request $request, Country $country, SettingsManager $settings): RedirectResponse
    {
        DB::transaction(function () use ($country) {
            Country::query()->update(['is_default' => false]);
            $country->active = true;
            $country->is_default = true;
            $country->save();
        });

        $groupGeneralId = \App\Models\SettingsGroup::query()->where('key', 'general')->value('id');
        if ($groupGeneralId) {
            Setting::query()->updateOrCreate(
                ['settings_group_id' => $groupGeneralId, 'key' => 'default_country_iso2'],
                ['value' => $country->iso2, 'type' => 'string', 'is_public' => false, 'is_encrypted' => false],
            );

            if ($country->currency_code) {
                Setting::query()->updateOrCreate(
                    ['settings_group_id' => $groupGeneralId, 'key' => 'default_currency_code'],
                    ['value' => $country->currency_code, 'type' => 'string', 'is_public' => false, 'is_encrypted' => false],
                );
            }
        }

        $settings->clearCache();

        return back();
    }
}

