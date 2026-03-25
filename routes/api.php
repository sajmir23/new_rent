<?php

use App\Http\Controllers\Api\V1\BookingsController;
use App\Http\Controllers\Api\V1\ReferenceDataController;
use App\Http\Controllers\Api\V1\RegisterSellerController;
use App\Http\Controllers\Api\V1\StripeWebhookController;
use App\Http\Controllers\Api\V1\VehiclesController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\PokWebhookController;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    // Vehicles
    Route::get('/all-vehicles', [VehiclesController::class, 'allVehicles'])->name('api.all_vehicles');
    Route::get('/airport-vehicles', [VehiclesController::class, 'airportVehicles'])->name('api.airport_vehicles');
    Route::get('/electric-vehicles', [VehiclesController::class, 'electricVehicles'])->name('api.electric_vehicles');
    Route::get('/delivery-vehicles', [VehiclesController::class, 'deliveryVehicles'])->name('api.delivery_vehicles');
    Route::post('/vehicles/filters', [VehiclesController::class, 'filtersPage'])->name('api.vehicles.filters_page');
    Route::get('/vehicle/{id}', [VehiclesController::class, 'vehicleShow'])->name('api.show_vehicle');

    //Reference Data
    Route::get('/reference-data', [ReferenceDataController::class, 'index'])->name('api.reference_data');

    // Contact Form
    Route::post('/contact-form',[ContactFormController::class,'store'])->name('api.contact_form');

    // News Letter
    Route::post('/news-letter',[NewsLetterController::class,'store'])->name('api.news_letter');

    // Register a new seller
    Route::post('/register-seller',[RegisterSellerController::class,'registerSeller'])->name('api.company_admin');
});

Route::post('/bookings/store', [BookingsController::class, 'store'])->name('api.bookings.store');
Route::get('/bookings/success', [BookingsController::class, 'success'])->name('api.bookings.success');
Route::get('/bookings/cancel', [BookingsController::class, 'cancel'])->name('api.bookings.cancel');
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::post('/pok/webhook', [PokWebhookController::class, 'handle'])->name('api.pok.webhook');

/*Route::get('/stripe/success', [BookingsApiController::class, 'success'])->name('api.stripe.success');
Route::get('/stripe/cancel', [BookingsApiController::class, 'cancel'])->name('api.stripe.cancel');*/
