<?php

use App\Http\Controllers\AssistantTaskController;
use App\Http\Controllers\AssistantTaskReorderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SettingsController;
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
});
