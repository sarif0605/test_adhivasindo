<?php

use App\Http\Controllers\CalenderController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verify-email');

Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::get('/calender', [CalenderController::class, 'index'])->name('calender');

Route::middleware('auth', 'verified')->group(function () {
    Route::controller(ContentController::class)->prefix('content')->group(function () {
        Route::get('', 'index')->name('content');
        Route::get('create', 'create')->name('content.create');
        Route::post('store', 'store')->name('content.store');
        Route::get('edit/{id}', 'edit')->name('content.edit');
        Route::put('update/{id}', 'update')->name('content.update');
        Route::get('show/{id}', 'show')->name('content.show');
        Route::delete('destroy/{id}', 'destroy')->name('content.destroy');
    });
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
