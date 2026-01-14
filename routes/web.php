<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    Route::get('/rooms/trash', [RoomController::class, 'trash'])->name('rooms.trash');
    Route::post('/rooms/{id}/restore', [RoomController::class, 'restore'])->name('rooms.restore');
    Route::delete('/rooms/{id}/force-delete', [RoomController::class, 'forceDelete'])->name('rooms.force-delete');
    Route::get('/rooms/export', [RoomController::class, 'export'])->name('rooms.export');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/types', [RoomTypeController::class, 'index'])->name('types.index');
    Route::post('/types', [RoomTypeController::class, 'store'])->name('types.store');
    Route::put('/types/{type}', [RoomTypeController::class, 'update'])->name('types.update');
    Route::delete('/types/{type}', [RoomTypeController::class, 'destroy'])->name('types.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
