<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Contoh struktur pembatasan akses per role. Modul nyata akan
// menggantikan Route::view placeholder ini pada tahap berikutnya.
Route::middleware('auth')->group(function () {
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
