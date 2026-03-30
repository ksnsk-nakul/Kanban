<?php

use App\Http\Controllers\AssistantTaskController;
use App\Http\Controllers\AssistantTaskReorderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\TranslationController;
use App\Http\Controllers\Admin\AuthMethodController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::post('/preferences/locale', [PreferenceController::class, 'setLocale'])->name('preferences.locale');
Route::post('/preferences/theme', [PreferenceController::class, 'setTheme'])->name('preferences.theme');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::post('/assistant/tasks', [AssistantTaskController::class, 'store'])->name('assistant.tasks.store');
    Route::post('/assistant/tasks/{task}/toggle', [AssistantTaskController::class, 'toggleComplete'])->name('assistant.tasks.toggle');
    Route::post('/assistant/tasks/reorder', AssistantTaskReorderController::class)->name('assistant.tasks.reorder');

    Route::post('/preferences/stage', [PreferenceController::class, 'setStage'])->name('preferences.stage');
});

Route::middleware(['auth', 'role:super-admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
    Route::get('/roles/{role}', [RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::post('/permissions', [PermissionController::class, 'store'])->name('permissions.store');

    Route::get('/languages', [LanguageController::class, 'index'])->name('languages.index');
    Route::post('/languages', [LanguageController::class, 'store'])->name('languages.store');
    Route::put('/languages/{language}', [LanguageController::class, 'update'])->name('languages.update');
    Route::post('/languages/{language}/toggle', [LanguageController::class, 'toggle'])->name('languages.toggle');
    Route::post('/languages/{language}/default', [LanguageController::class, 'setDefault'])->name('languages.default');

    Route::get('/countries', [CountryController::class, 'index'])->name('countries.index');
    Route::put('/countries/{country}', [CountryController::class, 'update'])->name('countries.update');
    Route::post('/countries/{country}/toggle', [CountryController::class, 'toggle'])->name('countries.toggle');
    Route::post('/countries/{country}/default', [CountryController::class, 'setDefault'])->name('countries.default');

    Route::get('/translations', [TranslationController::class, 'index'])->name('translations.index');
    Route::post('/translations', [TranslationController::class, 'store'])->name('translations.store');
    Route::put('/translations/{translation}', [TranslationController::class, 'update'])->name('translations.update');
    Route::delete('/translations/{translation}', [TranslationController::class, 'destroy'])->name('translations.destroy');

    Route::get('/auth-methods', [AuthMethodController::class, 'index'])->name('auth-methods.index');
    Route::post('/auth-methods/{authMethod}/toggle', [AuthMethodController::class, 'toggle'])->name('auth-methods.toggle');
});
