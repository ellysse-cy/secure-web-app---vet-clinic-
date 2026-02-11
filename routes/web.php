<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    // Dashboard (both admin and user)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // User routes
    Route::middleware('role:user')->group(function () {
        Route::resource('pets', PetController::class);
        Route::resource('appointments', AppointmentController::class)->except(['show', 'edit', 'update']);
    });
    
    // Admin routes
    Route::middleware('role:admin')->prefix('admin')->group(function () {
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/appointments', [AdminController::class, 'appointments'])->name('admin.appointments');
        Route::patch('/appointments/{appointment}', [AdminController::class, 'updateAppointment'])->name('admin.appointments.update');
    });
});

require __DIR__.'/auth.php';