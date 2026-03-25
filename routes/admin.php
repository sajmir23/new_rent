<?php

use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\BookingStatusesController;
use App\Http\Controllers\Admin\BrandsController;
use App\Http\Controllers\Admin\CancellationReasonsController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CompaniesController;
use App\Http\Controllers\Admin\CompanyAdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeaturesController;
use App\Http\Controllers\Admin\FuelTypesController;
use App\Http\Controllers\Admin\LoginHistoryController;
use App\Http\Controllers\Admin\LogsController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PaymentStatusesController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\TransmissionTypesController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VehicleCategoriesController;
use App\Http\Controllers\Admin\VehicleModelsController;
use App\Http\Controllers\Admin\VehicleStatusesController;
use App\Http\Controllers\ContactFormController;
use Illuminate\Support\Facades\Route;

Route::middleware([\App\Http\Middleware\isAdmin::class,\App\Http\Middleware\isActive::class,\App\Http\Middleware\AuthUserSetLocale::class])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/financials/overview', [DashboardController::class, 'financialsOverview'])->name('financials');
    Route::get('/dashboard/financials/chart', [DashboardController::class, 'financials'])->name('financials_chart');

    //locale
    //Route::post('/update/locale', [DashboardController::class, 'updateLocale'])->name('update_locale');

    //account
    Route::get('/my-account', [AccountController::class, 'myAccount'])->name('account');
    Route::put('/my-account/update-info/{id}', [AccountController::class, 'update'])->name('account_update');

    //Users
    Route::get('/system-users/index', [UserController::class, 'index'])->name('users.index');
    Route::get('/system-users/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/system-users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/system-users/store', [UserController::class, 'store'])->name('users.store');
    Route::get('/system-users/edit/{id}', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/system-users/update/{id}', [UserController::class, 'update'])->name('users.update');
    Route::post('/system-users/delete', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/system-users/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/system-users/update-password/', [UserController::class, 'updatePassword'])->name('users.update_password');

    //impersonate users
    Route::get('/{user}/impersonate', [UserController::class, 'impersonate'])->name('users.impersonate');

    //Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
    Route::get('/roles/search', [RoleController::class, 'search'])->name('roles.search');
    Route::get('/roles/create', [RoleController::class, 'create'])->name('roles.create');
    Route::get('/roles/{id}/permissions', [RoleController::class, 'managePermissions'])
        ->name('roles.permissions');
    Route::post('/roles/store', [RoleController::class, 'store'])->name('roles.store');
    Route::put('/roles/update/{id}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('/roles/delete', [RoleController::class, 'destroy'])->name('roles.destroy');

    //Permissions
    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/permission/{permission_id}/users', [PermissionController::class, 'checkUsers'])->name('permissions.users');
    Route::get('/permission/create', [PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/permission/store', [PermissionController::class, 'store'])->name('permissions.store');


    Route::get('/activity-logs/index', [LogsController::class, 'activityLogs'])->name('logs.activity');
    Route::get('/forbidden-logs/index', [LogsController::class, 'forbiddenLogs'])->name('logs.forbidden');

    //login history
    Route::get('/login-history/index',[LoginHistoryController::class,'index'])->name('login_history.index');

    //booking_statuses
    Route::get('/booking-statuses', [BookingStatusesController::class, 'index'])->name('booking_statuses.index');
    Route::get('/booking-statuses/search', [BookingStatusesController::class, 'search'])->name('booking_statuses.search');

    //vehicles_categories
    Route::get('/vehicle-categories/index',[VehicleCategoriesController::class,'index'])->name('vehicle_categories.index');
    Route::get('/vehicle-categories/search', [VehicleCategoriesController::class, 'search'])->name('vehicle_categories.search');
    Route::get('/vehicle-categories/create', [VehicleCategoriesController::class, 'create'])->name('vehicle_categories.create');
    Route::post('/vehicle-categories/store', [VehicleCategoriesController::class, 'store'])->name('vehicle_categories.store');
    Route::get('/vehicle-categories/edit/{id}', [VehicleCategoriesController::class, 'edit'])->name('vehicle_categories.edit');
    Route::get('/vehicle-categories/show/{id}', [VehicleCategoriesController::class, 'show'])->name('vehicle_categories.show');
    Route::put('/vehicle-categories/update/{id}', [VehicleCategoriesController::class, 'update'])->name('vehicle_categories.update');
    Route::post('/vehicle-categories/delete/', [VehicleCategoriesController::class, 'delete'])->name('vehicle_categories.destroy');


    //transmission_types
    Route::get('/transmission-types/index',[TransmissionTypesController::class,'index'])->name('transmission_types.index');
    Route::get('/transmission-types/search', [TransmissionTypesController::class, 'search'])->name('transmission_types.search');
    Route::get('/transmission-types/create', [TransmissionTypesController::class, 'create'])->name('transmission_types.create');
    Route::post('/transmission-types/store', [TransmissionTypesController::class, 'store'])->name('transmission_types.store');
    Route::get('/transmission-types/edit/{id}', [TransmissionTypesController::class, 'edit'])->name('transmission_types.edit');
    Route::get('/transmission-types/show/{id}', [TransmissionTypesController::class, 'show'])->name('transmission_types.show');
    Route::put('/transmission-types/update/{id}', [TransmissionTypesController::class, 'update'])->name('transmission_types.update');
    Route::post('/transmission-types/delete/', [TransmissionTypesController::class, 'delete'])->name('transmission_types.destroy');

    //features
    Route::get('/features/index',[FeaturesController::class,'index'])->name('features.index');
    Route::get('/features/search', [FeaturesController::class, 'search'])->name('features.search');
    Route::get('/features/create', [FeaturesController::class, 'create'])->name('features.create');
    Route::post('/features/store', [FeaturesController::class, 'store'])->name('features.store');
    Route::get('/features/edit/{id}', [FeaturesController::class, 'edit'])->name('features.edit');
    Route::get('/features/show/{id}', [FeaturesController::class, 'show'])->name('features.show');
    Route::put('/features/update/{id}', [FeaturesController::class, 'update'])->name('features.update');
    Route::post('/features/delete/', [FeaturesController::class, 'delete'])->name('features.destroy');

    //fuel types
    Route::get('/fuel-types/index',[FuelTypesController::class,'index'])->name('fuel_types.index');
    Route::get('/fuel-types/create', [FuelTypesController::class, 'create'])->name('fuel_types.create');
    Route::post('/fuel-types/store', [FuelTypesController::class, 'store'])->name('fuel_types.store');
    Route::get('/fuel-types/edit/{id}', [FuelTypesController::class, 'edit'])->name('fuel_types.edit');
    Route::get('/fuel-types/show/{id}', [FuelTypesController::class, 'show'])->name('fuel_types.show');
    Route::put('/fuel-types/update/{id}', [FuelTypesController::class, 'update'])->name('fuel_types.update');
    Route::post('/fuel-types/delete/', [FuelTypesController::class, 'delete'])->name('fuel_types.destroy');
    Route::get('/fuel-types/search', [FuelTypesController::class, 'search'])->name('fuel_types.search');

    //brands
    Route::get('/brands/index',[BrandsController::class,'index'])->name('brands.index');
    Route::get('/brands/search', [BrandsController::class, 'search'])->name('brands.search');
    Route::get('/brands/create', [BrandsController::class, 'create'])->name('brands.create');
    Route::post('/brands/store', [BrandsController::class, 'store'])->name('brands.store');
    Route::get('/brands/edit/{id}', [BrandsController::class, 'edit'])->name('brands.edit');
    Route::get('/brands/show/{id}', [BrandsController::class, 'show'])->name('brands.show');
    Route::put('/brands/update/{id}', [BrandsController::class, 'update'])->name('brands.update');
    Route::post('/brands/delete/', [BrandsController::class, 'delete'])->name('brands.destroy');

    //models
    Route::get('/models/index',[VehicleModelsController::class,'index'])->name('vehicle_model.index');
    Route::get('/models/search', [VehicleModelsController::class, 'search'])->name('vehicle_model.search');
    Route::get('/models/create', [VehicleModelsController::class, 'create'])->name('vehicle_model.create');
    Route::post('/models/store', [VehicleModelsController::class, 'store'])->name('vehicle_model.store');
    Route::get('/models/edit/{id}', [VehicleModelsController::class, 'edit'])->name('vehicle_model.edit');
    Route::get('/models/show/{id}', [VehicleModelsController::class, 'show'])->name('vehicle_model.show');
    Route::put('/models/update/{id}', [VehicleModelsController::class, 'update'])->name('vehicle_model.update');
    Route::post('/models/delete/', [VehicleModelsController::class, 'delete'])->name('vehicle_model.destroy');

    //Companies
    Route::get('/companies/index',[CompaniesController::class,'index'])->name('companies.index');
    Route::get('/companies/search', [CompaniesController::class, 'search'])->name('companies.search');
    Route::get('/companies/create', [CompaniesController::class, 'create'])->name('companies.create');
    Route::post('/companies/store', [CompaniesController::class, 'store'])->name('companies.store');
    Route::get('/companies/edit/{id}', [CompaniesController::class, 'edit'])->name('companies.edit');
    Route::get('/companies/show/{id}', [CompaniesController::class, 'show'])->name('companies.show');
    Route::put('/companies/update/{id}', [CompaniesController::class, 'update'])->name('companies.update');
    Route::post('/companies/delete/', [CompaniesController::class, 'delete'])->name('companies.destroy');

    //staff
    Route::get('/staff/index',[StaffController::class,'index'])->name('staff.index');
    Route::get('/staff/search', [StaffController::class, 'search'])->name('staff.search');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('staff.edit');
    Route::get('/staff/show/{id}', [StaffController::class, 'show'])->name('staff.show');
    Route::put('/staff/update/{id}', [StaffController::class, 'update'])->name('staff.update');
    Route::post('/staff/delete/', [StaffController::class, 'delete'])->name('staff.destroy');

    //company_admin

    Route::get('/company_admin/index',[CompanyAdminController::class,'index'])->name('company_admin.index');
    Route::get('/company_admin/create', [CompanyAdminController::class, 'create'])->name('company_admin.create');
    Route::post('/company_admin/store', [CompanyAdminController::class, 'store'])->name('company_admin.store');
    Route::get('/company_admin/edit/{id}', [CompanyAdminController::class, 'edit'])->name('company_admin.edit');
    Route::get('/company_admin/show/{id}', [CompanyAdminController::class, 'show'])->name('company_admin.show');
    Route::put('/company_admin/update/{id}', [CompanyAdminController::class, 'update'])->name('company_admin.update');
    Route::post('/company_admin/delete/', [CompanyAdminController::class, 'delete'])->name('company_admin.destroy');
    Route::get('/company_admin/search', [CompanyAdminController::class, 'search'])->name('company_admin.search');

    //cancellation_reasions
    Route::get('/cancellation_reasons/index', [CancellationReasonsController::class, 'index'])->name('cancellation_reasons.index');
    Route::get('/cancellation_reasons/create', [CancellationReasonsController::class, 'create'])->name('cancellation_reasons.create');
    Route::post('cancellation_reasons/store', [CancellationReasonsController::class, 'store'])->name('cancellation_reasons.store');
    Route::get('/cancellation_reasons/edit/{id}', [CancellationReasonsController::class, 'edit'])->name('cancellation_reasons.edit');
    Route::get('/cancellation_reasons/show/{id}', [CancellationReasonsController::class, 'show'])->name('cancellation_reasons.show');
    Route::put('/cancellation_reasons/update/{id}', [CancellationReasonsController::class, 'update'])->name('cancellation_reasons.update');
    Route::post('/cancellation_reasons/delete/', [CancellationReasonsController::class, 'delete'])->name('cancellation_reasons.destroy');
    Route::get('/cancellation_reasons/search', [CancellationReasonsController::class, 'search'])->name('cancellation_reasons.search');
    //vehicle_statuses
    Route::get('/vehicle_statuses/index',[VehicleStatusesController::class,'index'])->name('vehicle_statuses.index');
    Route::get('/vehicle_statuses/search',[VehicleStatusesController::class,'search'])->name('vehicle_statuses.search');
    //payment_statuses
    Route::get('/payment_statuses/index',[PaymentStatusesController::class,'index'])->name('payment_statuses.index');
    Route::get('/payment_statuses/search',[PaymentStatusesController::class,'search'])->name('payment_statuses.search');


    Route::get('/city/index',[CityController::class,'index'])->name('city.index');
    Route::get('/city/search', [CityController::class, 'search'])->name('city.search');

    Route::get('/notifications/all',[NotificationController::class,'index'])->name('notifications.index');
    Route::post('/notifications/marked/{id}',[NotificationController::class,'marked'])->name('notifications.markAsRead');

    Route::get('/contact-form',[ContactFormController::class,'index'])->name('contact_index');

});
