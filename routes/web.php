<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\AuthController;

// routes/web.php

// Home route - redirect to dashboard for authenticated users, or show welcome page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('login');
    }
    return redirect()->route('login');
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Registration routes
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reports
    Route::resource('reports', ReportController::class);

    // Approval workflow (Manager/Admin)
    Route::post('/reports/{report}/approve', [ReportController::class, 'approve'])->name('reports.approve');
    Route::post('/reports/{report}/reject', [ReportController::class, 'reject'])->name('reports.reject');

    // Admin-only
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit.logs');
        Route::get('/storage-settings', [StorageController::class, 'index'])->name('storage.settings');
    });
});


