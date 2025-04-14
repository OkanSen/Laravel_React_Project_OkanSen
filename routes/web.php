<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::prefix('/{locale?}')->where(['locale' => 'en|fil'])->group(function () {
    Route::name('backoffice.')->group(function () {
        Route::get('/', [HomeController::class, 'index']);

        Route::get('/env-check', function () {
            return env('CHECK_ENV_WORKS', 'nope');
        });

        // ✅ React dashboard route
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');
    });
});

// Redirect /dashboard to /en/dashboard if locale is missing
Route::redirect('/dashboard', '/en/dashboard');
