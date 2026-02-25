<?php

declare(strict_types=1);

use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::livewire('settings/profile', 'pages::settings.profile')->name('profile.edit');

    Route::middleware(['verified'])->group(function () {
        Route::view('dashboard', 'dashboard')
            ->name('dashboard');
        Route::livewire('settings/password', 'pages::settings.password')->name('user-password.edit');
        Route::livewire('settings/appearance', 'pages::settings.appearance')->name('appearance.edit');
        $middleware = [];
        if (Features::canManageTwoFactorAuthentication() && Features::optionEnabled(
            Features::twoFactorAuthentication(),
            'confirmPassword'
        )) {
            $middleware[] = 'password.confirm';
        }

        Route::livewire('settings/two-factor', 'pages::settings.two-factor')
            ->middleware($middleware)
            ->name('two-factor.show');
    });
});
