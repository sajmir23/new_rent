<?php


use App\Http\Controllers\Admin\BookingStatusesController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CancellationReasonsController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\FeaturesController;
use App\Http\Controllers\Admin\FuelTypesController;
use App\Http\Controllers\Admin\TransmissionTypesController;
use App\Http\Controllers\Admin\VehicleCategoriesController;
use App\Http\Controllers\Admin\VehicleModelsController;
use App\Http\Controllers\Admin\VehicleStatusesController;
use App\Http\Controllers\Company\AdditionalServicesController;
use App\Http\Controllers\Company\BookingsController;
use App\Http\Controllers\Company\CompanyController;
use App\Http\Controllers\Company\CompanyPermissionController;
use App\Http\Controllers\Company\CompanyRolesController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\DeliveriesController;
use App\Http\Controllers\Company\InsuranceController;
use App\Http\Controllers\Company\NotificationController;
use App\Http\Controllers\Company\SeasonalPricesController;
use App\Http\Controllers\Company\StaffController;
use App\Http\Controllers\Company\TariffController;
use App\Http\Controllers\Company\VehicleImagesController;
use App\Http\Controllers\Company\VehiclesController;
use Illuminate\Support\Facades\Route;

Route::middleware([\App\Http\Middleware\isCompany::class,\App\Http\Middleware\isActive::class,\App\Http\Middleware\AuthUserSetLocale::class,\App\Http\Middleware\RestrictCrossCompanyAccess::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/financials/overview', [DashboardController::class, 'financialsOverview'])->name('financials');
    Route::get('/dashboard/financials/chart', [DashboardController::class, 'financials'])->name('financials_chart');

    //locale
    Route::post('/update/locale', [DashboardController::class, 'updateLocale'])->name('update_locale');

    //Roles
    Route::get('/roles', [CompanyRolesController::class, 'index'])->name('roles.index');
    Route::get('/roles/search', [CompanyRolesController::class, 'search'])->name('roles.search');
    Route::get('/roles/create', [CompanyRolesController::class, 'create'])->name('roles.create');
    Route::get('/roles/{id}/permissions', [CompanyRolesController::class, 'managePermissions'])->name('roles.permissions');
    Route::post('/roles/store', [CompanyRolesController::class, 'store'])->name('roles.store');
    Route::put('/roles/update/{id}', [CompanyRolesController::class, 'update'])->name('roles.update');
    Route::delete('/roles/delete', [CompanyRolesController::class, 'destroy'])->name('roles.destroy');

    //Permissions
    Route::get('/permissions', [CompanyPermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/{permission_id}/users', [CompanyPermissionController::class, 'checkUsers'])->name('permissions.users');
    Route::get('/permission/create', [CompanyPermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permission/store', [CompanyPermissionController::class, 'store'])->name('permissions.store');


    Route::get('/vehicle-categories/index',[VehicleCategoriesController::class,'index'])->name('vehicle_categories.index');
    Route::get('/vehicle-categories/search',[VehicleCategoriesController::class,'search'])->name('vehicle_categories.search');

    Route::get('/transmission-types/index',[TransmissionTypesController::class,'index'])->name('transmission_types.index');
    Route::get('/transmission-types/search',[TransmissionTypesController::class,'search'])->name('transmission_types.search');

    Route::get('/features/index',[FeaturesController::class,'index'])->name('features.index');

    Route::get('/fuel-types/index',[FuelTypesController::class,'index'])->name('fuel_types.index');
    Route::get('/fuel-types/search',[FuelTypesController::class,'search'])->name('fuel_types.search');


    Route::get('/brands/index',[BrandsController::class,'index'])->name('brands.index');
    Route::get('/brands/search',[BrandsController::class,'search'])->name('brands.search');

    Route::get('/vehicle-models/index',[VehicleModelsController::class,'index'])->name('vehicle_model.index');
    Route::get('/vehicle-models/search',[VehicleModelsController::class,'search'])->name('vehicle_model.search');

    Route::get('/cancellation_reasons/index',[CancellationReasonsController::class,'index'])->name('cancellation_reasons.index');

    Route::get('/vehicle-statuses/search',[VehicleStatusesController::class,'search'])->name('vehicle_statuses.search');
    //vehicles
    Route::get('/vehicles/index',[VehiclesController::class,'index'])->name('vehicles.index');
    Route::get('/vehicles/search', [VehiclesController::class, 'search'])->name('vehicles.search');
    Route::get('/vehicles/create', [VehiclesController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles/store', [VehiclesController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicles/edit/{id}', [VehiclesController::class, 'edit'])->name('vehicles.edit');
    Route::get('/vehicles/show/{id}', [VehiclesController::class, 'show'])->name('vehicles.show');
    Route::put('/vehicles/update/{id}', [VehiclesController::class, 'update'])->name('vehicles.update');
    Route::post('/vehicles/delete/', [VehiclesController::class, 'delete'])->name('vehicles.destroy');
    Route::post('/vehicles/images-store', [VehicleImagesController::class, 'store'])->name('vehicles.image_store');


    Route::get('/company-data/index',[CompanyController::class,'index'])->name('company_data.index');
    Route::get('/company-data/{id}/edit',[CompanyController::class,'edit'])->name('company_data.edit');
    Route::put('/company-data/{id}/update',[CompanyController::class,'update'])->name('company_data.update');
    Route::get('/company-data/staff',[CompanyController::class,'staffList'])->name('company_data.staff');

    //staff
    Route::get('/staff/index',[StaffController::class,'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
    Route::get('/staff/show/{id}', [StaffController::class, 'show'])->name('staff.show');
    Route::put('staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::post('/staff/delete/', [StaffController::class, 'delete'])->name('staff.destroy');
    Route::get('/staff/search', [StaffController::class, 'search'])->name('staff.search');

    //bookings
    Route::get('/bookings/index',[BookingsController::class,'index'])->name('bookings.index');
    Route::get('/bookings/create',[BookingsController::class,'create'])->name('bookings.create');
    Route::post('/bookings/store',[BookingsController::class,'store'])->name('bookings.store');
    Route::post('/bookings/cancellation',[BookingsController::class,'cancellation'])->name('bookings.cancel');
    Route::get('/bookings/show/{id}', [BookingsController::class, 'show'])->name('bookings.show');
    Route::post('/bookings/pickup', [BookingsController::class, 'pickup'])->name('bookings.pickup');
    Route::post('/bookings/dropoff', [BookingsController::class, 'dropoff'])->name('bookings.dropoff');
    Route::get('/bookings/calendar', [BookingsController::class, 'calendar'])->name('bookings.calendar');
    Route::get('/bookings/calendar-data', [BookingsController::class, 'calendarData'])->name('bookings.calendar_data');

    //bookings statuses
    Route::get('/booking-statuses/search', [BookingStatusesController::class, 'search'])->name('booking_statuses.search');

    //insurances
    Route::get('/insurances/index',[InsuranceController::class,'index'])->name('insurances.index');
    Route::get('/insurances/create',[InsuranceController::class,'create'])->name('insurances.create');
    Route::post('/insurances/store',[InsuranceController::class,'store'])->name('insurances.store');
    Route::get('/insurances/edit/{id}', [InsuranceController::class, 'edit'])->name('insurances.edit');
    Route::get('/insurances/show/{id}', [InsuranceController::class, 'show'])->name('insurances.show');
    Route::put('/insurances/update/{id}', [InsuranceController::class, 'update'])->name('insurances.update');
    Route::post('insurances/delete/',[InsuranceController::class,'delete'])->name('insurances.destroy');
    Route::get('/insurances/search', [InsuranceController::class, 'search'])->name('insurances.search');

    //additional-services
    Route::get('/additional-services/index',[AdditionalServicesController::class,'index'])->name('additional_services.index');
    Route::get('/additional-services/create',[AdditionalServicesController::class,'create'])->name('additional_services.create');
    Route::post('/additional-services/store',[AdditionalServicesController::class,'store'])->name('additional_services.store');
    Route::get('/additional-services/edit/{id}', [AdditionalServicesController::class, 'edit'])->name('additional_services.edit');
    Route::get('/additional-services/show/{id}', [AdditionalServicesController::class, 'show'])->name('additional_services.show');
    Route::put('/additional-services/update/{id}', [AdditionalServicesController::class, 'update'])->name('additional_services.update');
    Route::post('additional-services/delete/',[AdditionalServicesController::class,'delete'])->name('additional_services.destroy');
    Route::get('/additional-services/search', [AdditionalServicesController::class, 'search'])->name('additional_services.search');

    //seasonal_prices
    Route::get('/seasonal-prices/index',[SeasonalPricesController::class,'index'])->name('seasonal_prices.index');
    Route::get('/seasonal-prices/create',[SeasonalPricesController::class,'create'])->name('seasonal_prices.create');
    Route::post('/seasonal-prices/store',[SeasonalPricesController::class,'store'])->name('seasonal_prices.store');
    Route::get('/seasonal-prices/edit/{id}', [SeasonalPricesController::class, 'edit'])->name('seasonal_prices.edit');
    Route::put('/seasonal-prices/update/{id}', [SeasonalPricesController::class, 'update'])->name('seasonal_prices.update');
    Route::post('seasonal-prices/delete/',[SeasonalPricesController::class,'delete'])->name('seasonal_prices.destroy');
    Route::get('/seasonal-prices/search', [SeasonalPricesController::class, 'search'])->name('seasonal_prices.search');
    Route::get('/seasonal-prices/show/{id}', [SeasonalPricesController::class, 'show'])->name('seasonal_prices.show');

    Route::get('/tariff/index',[TariffController::class,'index'])->name('tariff.index');
    Route::get('/tariff/create',[TariffController::class,'create'])->name('tariff.create');
    Route::post('/tariff/store',[TariffController::class,'store'])->name('tariff.store');
    Route::get('/tariff/edit/{id}', [TariffController::class, 'edit'])->name('tariff.edit');
    Route::put('/tariff/update/{id}', [TariffController::class, 'update'])->name('tariff.update');
    Route::post('tariff/delete/',[TariffController::class,'delete'])->name('tariff.destroy');
    Route::get('/tariff/search', [TariffController::class, 'search'])->name('tariff.search');

    Route::get('/city/search', [CityController::class, 'search'])->name('city.search');

    Route::get('/delivery/index',[DeliveriesController::class,'index'])->name('deliveries.index');
    Route::get('/delivery/create',[DeliveriesController::class,'create'])->name('deliveries.create');
    Route::post('/delivery/store',[DeliveriesController::class,'store'])->name('deliveries.store');
    Route::get('/delivery/edit/{id}', [DeliveriesController::class, 'edit'])->name('deliveries.edit');
    Route::get('/delivery/show/{id}', [DeliveriesController::class, 'show'])->name('deliveries.show');
    Route::put('/delivery/update/{id}', [DeliveriesController::class, 'update'])->name('deliveries.update');
    Route::post('delivery/delete/',[DeliveriesController::class,'delete'])->name('deliveries.destroy');
    Route::get('/delivery/search', [DeliveriesController::class, 'search'])->name('deliveries.search');

    Route::get('/notifications/all',[NotificationController::class,'index'])->name('notifications.index');
    Route::post('/notifications/marked/{id}',[NotificationController::class,'marked'])->name('notifications.markAsRead');


});