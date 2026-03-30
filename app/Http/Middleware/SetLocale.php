<?php

namespace App\Http\Middleware;

use App\Core\Settings\SettingsManager;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class SetLocale
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = null;

        if ($request->user()?->locale) {
            $locale = $request->user()->locale;
        } elseif ($request->hasSession()) {
            $sessionLocale = $request->session()->get('locale');
            if (is_string($sessionLocale) && $sessionLocale !== '') {
                $locale = $sessionLocale;
            }
        }

        if (!$locale) {
            try {
                $locale = app(SettingsManager::class)->get('general.default_language', config('app.locale'));
            } catch (\Throwable $e) {
                $locale = config('app.locale');
            }
        }

        if (is_string($locale) && $locale !== '') {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
