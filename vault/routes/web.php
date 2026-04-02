<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\PasswordEntryController;

Route::get('/', function () {
    return Auth::check() ? redirect()->route('dashboard') : view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [VaultController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::resource('vaults', VaultController::class);

    Route::post('vaults/{vault}/entries', [PasswordEntryController::class, 'store'])->name('vaults.entries.store');
    Route::get('vaults/{vault}/entries/{entry}/edit', [PasswordEntryController::class, 'edit'])->name('vaults.entries.edit');
    Route::put('vaults/{vault}/entries/{entry}', [PasswordEntryController::class, 'update'])->name('vaults.entries.update');
    Route::delete('vaults/{vault}/entries/{entry}', [PasswordEntryController::class, 'destroy'])->name('vaults.entries.destroy');
});
