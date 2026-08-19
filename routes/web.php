<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->middleware('throttle:10,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // Contoh struktur pembatasan akses per role. Modul nyata akan
    // menggantikan Route::view placeholder ini pada tahap berikutnya.
    Route::middleware('role:superadmin')->prefix('superadmin')->group(function () {
        Route::view('/dashboard', 'welcome')->name('superadmin.dashboard');
    });

    Route::middleware('role:superadmin,manajer')->prefix('manajemen')->group(function () {
        Route::view('/dashboard', 'welcome')->name('manajemen.dashboard');
    });

    Route::middleware('role:superadmin,manajer,spv')->prefix('spv')->group(function () {
        Route::view('/dashboard', 'welcome')->name('spv.dashboard');
    });

    Route::middleware('role:superadmin,manajer,spv,leader')->prefix('leader')->group(function () {
        Route::view('/dashboard', 'welcome')->name('leader.dashboard');
    });

    Route::middleware('role:superadmin,manajer,spv,leader,staff')->prefix('staff')->group(function () {
        Route::view('/dashboard', 'welcome')->name('staff.dashboard');
    });
});
