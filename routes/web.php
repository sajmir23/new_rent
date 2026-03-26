<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {

    if (auth()->check()) {
        return redirect()->route('admin.dashboard'); // Redirect to home or desired route
    }
    return redirect(\route('login'));
});*/

Route::get('/', [WelcomeController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/leave-impersonate', [UserController::class, 'leaveImpersonate'])->name('leave_impersonate');

Route::get('/search', [WelcomeController::class, 'searchCars'])->name('search.cars');
Route::get('/vehicle/{id}/booking-details', [WelcomeController::class, 'getVehicleBookingDetails'])->name('vehicle.booking.details');
Route::view('/privacy-policy', 'privacy')->name('privacy.policy');
Route::view('/terms', 'terms')->name('terms');