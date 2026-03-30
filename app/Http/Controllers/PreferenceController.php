<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class PreferenceController extends Controller
{
    public function setLocale(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'locale' => ['required', 'string', 'max:10'],
        ]);

        $language = Language::query()
            ->where('code', $data['locale'])
            ->where('active', true)
            ->first();

        abort_unless($language !== null, 404);

        if ($request->user()) {
            $request->user()->update(['locale' => $language->code]);
        }

        $request->session()->put('locale', $language->code);

        return back();
    }

    public function setTheme(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'theme_mode' => ['required', 'string', 'in:light,dark'],
        ]);

        if ($request->user()) {
            $request->user()->update(['theme_mode' => $data['theme_mode']]);
        }

        $request->session()->put('theme_mode', $data['theme_mode']);

        return back();
    }

    public function setStage(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'stage' => ['required', 'string', 'in:recovery,learning,job_search,freelance,product_builder'],
        ]);

        if ($request->user()) {
            $request->user()->update(['stage' => $data['stage']]);
        }

        return back();
    }
}
