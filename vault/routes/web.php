<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VaultController;
use App\Http\Controllers\PasswordEntryController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GeneratorController;
use App\Http\Controllers\PasswordShareController;

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
    Route::get('/shared', [PasswordShareController::class, 'index'])->name('shares.index');
    Route::post('/entries/{entry}/share', [PasswordShareController::class, 'store'])->name('shares.store');
    Route::put('/shares/{share}', [PasswordShareController::class, 'update'])->name('shares.update');
    Route::delete('/shares/{share}', [PasswordShareController::class, 'destroy'])->name('shares.destroy');

    // Vaults
    Route::resource('vaults', VaultController::class);

    // Password Entries (nested under vaults — create must come before {entry} to avoid conflict)
    Route::get('vaults/{vault}/entries/create', [PasswordEntryController::class, 'create'])->name('vaults.entries.create');
    Route::post('vaults/{vault}/entries', [PasswordEntryController::class, 'store'])->name('vaults.entries.store');
    Route::get('vaults/{vault}/entries/{entry}', [PasswordEntryController::class, 'show'])->name('vaults.entries.show');
    Route::get('vaults/{vault}/entries/{entry}/edit', [PasswordEntryController::class, 'edit'])->name('vaults.entries.edit');
    Route::put('vaults/{vault}/entries/{entry}', [PasswordEntryController::class, 'update'])->name('vaults.entries.update');
    Route::delete('vaults/{vault}/entries/{entry}', [PasswordEntryController::class, 'destroy'])->name('vaults.entries.destroy');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Password Generator
    Route::get('/generator', [GeneratorController::class, 'index'])->name('generator.index');
    Route::post('/generator', [GeneratorController::class, 'generate'])->name('generator.generate');
});

