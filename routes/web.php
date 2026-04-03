<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\Auth\TeacherRegisterController;
use App\Http\Controllers\ExportController;
use App\Livewire\TeacherDashboard;
use App\Livewire\StudentManagement;
use App\Livewire\ClassManagement;
use App\Livewire\AttendanceReports;

// Guest routes
Route::get('/', function () {
    return redirect()->route('teacher.login');
});

// Teacher authentication routes
Route::prefix('teacher')->name('teacher.')->group(function () {
    Route::middleware('guest:teacher')->group(function () {
        Route::get('login', [TeacherLoginController::class, 'showLoginForm'])->name('login');
        Route::post('login', [TeacherLoginController::class, 'login'])->name('login.submit');
        
        // Registration routes (optional - can be disabled in production)
        Route::get('register', [TeacherRegisterController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [TeacherRegisterController::class, 'register'])->name('register.submit');
    });
    
    Route::post('logout', [TeacherLoginController::class, 'logout'])->name('logout');
});

// Protected teacher routes
Route::middleware('auth:teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', TeacherDashboard::class)->name('dashboard');
    Route::get('/students', StudentManagement::class)->name('students');
    Route::get('/classes', ClassManagement::class)->name('classes');
    Route::get('/reports', AttendanceReports::class)->name('reports');
    Route::get('/download/export', [ExportController::class, 'downloadExport'])->name('download.export');
});
