<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ServiceTypeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceScheduleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;

// Redirect root to login if not authenticated
Route::get('/', function () {
    return redirect()->route('login');
});

// Auth routes are loaded from auth.php
require __DIR__.'/auth.php';

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    
    // User Management (Admin only)
    Route::middleware([\App\Http\Middleware\AdminMiddleware::class])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('permissions', PermissionController::class);

        // Settings routes
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/email', [SettingsController::class, 'email'])->name('email');
            Route::post('/email', [SettingsController::class, 'updateEmail'])->name('email.update');
            
            Route::get('/sms', [SettingsController::class, 'sms'])->name('sms');
            Route::post('/sms', [SettingsController::class, 'updateSms'])->name('sms.update');
            
            Route::get('/notification', [SettingsController::class, 'notification'])->name('notification');
            Route::post('/notification', [SettingsController::class, 'updateNotification'])->name('notification.update');
            
            Route::get('/general', [SettingsController::class, 'general'])->name('general');
            Route::post('/general', [SettingsController::class, 'updateGeneral'])->name('general.update');
        });
    });
    
    // Customer routes
    Route::post('customers/import', [CustomerController::class, 'import'])->name('customers.import');
    Route::get('customers/template/download', [CustomerController::class, 'downloadTemplate'])->name('customers.template');
    Route::resource('customers', CustomerController::class);
    
    // Vehicle routes
    Route::resource('vehicles', VehicleController::class);
    Route::get('vehicles/{vehicle}/service-history', [VehicleController::class, 'serviceHistory'])
        ->name('vehicles.service-history');
    Route::get('vehicles/{vehicle}/upcoming-services', [VehicleController::class, 'upcomingServices'])
        ->name('vehicles.upcoming-services');
    
    // Service Type routes
    Route::resource('service-types', ServiceTypeController::class);
    
    // Service routes
    Route::resource('services', ServiceController::class);
    
    // Service Schedule routes
    Route::get('service-schedules', [ServiceScheduleController::class, 'index'])->name('service-schedules.index');
    Route::get('service-schedules/create', [ServiceScheduleController::class, 'create'])->name('service-schedules.create');
    Route::post('service-schedules', [ServiceScheduleController::class, 'store'])->name('service-schedules.store');
    Route::get('service-schedules/{schedule}', [ServiceScheduleController::class, 'show'])->name('service-schedules.show');
    Route::get('service-schedules/{schedule}/edit', [ServiceScheduleController::class, 'edit'])->name('service-schedules.edit');
    Route::put('service-schedules/{schedule}', [ServiceScheduleController::class, 'update'])->name('service-schedules.update');
    Route::delete('service-schedules/{schedule}', [ServiceScheduleController::class, 'destroy'])->name('service-schedules.destroy');
    Route::post('service-schedules/{schedule}/send-reminder', [ServiceScheduleController::class, 'sendReminder'])
        ->name('service-schedules.send-reminder');
    Route::get('upcoming-reminders', [ServiceScheduleController::class, 'upcomingReminders'])
        ->name('service-schedules.upcoming-reminders');
    Route::get('service-schedules/overdue', [ServiceScheduleController::class, 'overdue'])
        ->name('service-schedules.overdue');
});

