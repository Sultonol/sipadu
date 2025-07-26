<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Authacces;
use Illuminate\Routing\RouteGroup;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/', function () {
    return view('welcome');
});

// Guest routes (Login & Register)
Route::middleware(['guest', 'authacces'])->group(function () {
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'createuser'])->name('register.store');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authentication'])->name('login.store');
});

// Authenticated & Verified routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Profile routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    });

    // General routes
    Route::get('/panduan', [DashboardController::class, 'panduan'])->name('panduan');
    Route::get('/detail-panduan/{id}', [DashboardController::class, 'detailpandu'])->name('complaint.detail');
    Route::get('/complete-pengadu', [DashboardController::class, 'complete'])->name('complete');

    // User complaint routes
    Route::prefix('complaint')->name('complaint.')->group(function () {
        Route::get('/add', [ComplaintController::class, 'add'])->name('add');
        Route::post('/create', [ComplaintController::class, 'create'])->name('create');
        Route::get('/{id}/edit', [ComplaintController::class, 'editComplaint'])->name('edit');
        Route::put('/{id}', [ComplaintController::class, 'updateComplaint'])->name('update');
    });

    // User complaints page - ROUTE BARU
    Route::middleware('user')->group(function () {
        Route::get('/my-complaints', [DashboardController::class, 'userComplaints'])->name('user.complaints');
        Route::get('/my-complaints/filter', [DashboardController::class, 'filterUserComplaints'])->name('user.complaints.filter');
        
        // ROUTE BARU: Untuk melihat semua pengaduan dari semua user
        Route::get('/all-complaints', [DashboardController::class, 'allComplaints'])->name('user.all.complaints');
        Route::get('/all-complaints/filter', [DashboardController::class, 'filterAllComplaints'])->name('user.all.complaints.filter');
    });

    // Backward compatibility routes
    Route::get('/complaint-add', [ComplaintController::class, 'add'])->name('complaint');
    Route::get('/complaints/{id}/edit', [ComplaintController::class, 'editComplaint'])->name('complaints.edit');
    Route::put('/complaints/{id}', [ComplaintController::class, 'updateComplaint'])->name('complaints.update');

    // Admin/Government routes - dengan middleware role check
    Route::middleware('admin_or_government')->prefix('admin')->name('admin.')->group(function () {
        // Complaint management
        Route::prefix('complaints')->name('complaints.')->group(function () {
            Route::get('/', [DashboardController::class, 'adminComplaintsList'])->name('list');
            Route::get('/{id}', [DashboardController::class, 'adminComplaintDetail'])->name('detail');
            Route::put('/{id}/status', [DashboardController::class, 'adminUpdateStatus'])->name('update-status');
            Route::post('/{id}/comment', [DashboardController::class, 'adminAddComment'])->name('add-comment');
            Route::post('/{id}/response', [DashboardController::class, 'adminAddResponse'])->name('add-response');
        });

        // Backward compatibility routes
        Route::get('/complaint/{id}', [DashboardController::class, 'adminComplaintDetail'])->name('complaint.detail');
        Route::put('/complaint/{id}/status', [DashboardController::class, 'adminUpdateStatus'])->name('update-status');
        Route::post('/complaint/{id}/comment', [DashboardController::class, 'adminAddComment'])->name('add-comment');
        Route::post('/complaint/{id}/response', [DashboardController::class, 'adminAddResponse'])->name('add-response');

        // Reports and Analytics
        Route::get('/reports', [AdminController::class, 'reports'])->name('reports');
        Route::get('/analytics', [DashboardController::class, 'getAnalytics'])->name('analytics');
        Route::get('/export', [DashboardController::class, 'exportComplaints'])->name('export');

        // Settings
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
        Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
    });

    // Admin only routes - User management
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [AdminController::class, 'usersList'])->name('list');
            Route::get('/create', [AdminController::class, 'createUser'])->name('create');
            Route::post('/', [AdminController::class, 'storeUser'])->name('store');
            Route::get('/{id}/edit', [AdminController::class, 'editUser'])->name('edit');
            Route::put('/{id}', [AdminController::class, 'updateUser'])->name('update');
            Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('delete');
        });
    });

    // API routes for AJAX calls
    Route::prefix('api')->name('api.')->group(function () {
        Route::get('/dashboard/stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');
        Route::get('/complaints/status/{status}', [DashboardController::class, 'getComplaintsByStatus'])->name('complaints.by-status');
        
        Route::middleware('admin_or_government')->group(function () {
            Route::get('/complaints/analytics', [DashboardController::class, 'getAnalytics'])->name('complaints.analytics');
            Route::post('/complaints/{id}/quick-update', [DashboardController::class, 'quickUpdateStatus'])->name('complaints.quick-update');
        });
    });

    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
});

// Email verification routes
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard')->with('success', 'Email berhasil diverifikasi!');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Link verifikasi telah dikirim!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');
});

// Fallback route untuk 404
Route::fallback(function () {
    return view('errors.404');
});