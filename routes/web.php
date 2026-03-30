<?php

use App\Http\Controllers\AssistantTaskController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PreferenceController;
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

    Route::post('/assistant/tasks', [AssistantTaskController::class, 'store'])->name('assistant.tasks.store');
    Route::post('/assistant/tasks/{task}/toggle', [AssistantTaskController::class, 'toggleComplete'])->name('assistant.tasks.toggle');

    Route::post('/preferences/stage', [PreferenceController::class, 'setStage'])->name('preferences.stage');
});
