<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\TeacherLoginController;
use App\Http\Controllers\Auth\TeacherRegisterController;
use App\Http\Controllers\Auth\StudentRegistrationController;
use App\Http\Controllers\ExportController;
use App\Livewire\TeacherDashboard;
use App\Livewire\StudentManagement;
use App\Livewire\ClassManagement;
use App\Livewire\AttendanceReports;
use App\Livewire\ExamManagement;
use App\Livewire\UserExam;
use App\Livewire\ExamResultsManagement;

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

// Student registration routes (public access)
Route::prefix('student')->name('student.')->group(function () {
    Route::get('register', [StudentRegistrationController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [StudentRegistrationController::class, 'register'])->name('register.submit');
    Route::get('register/success', [StudentRegistrationController::class, 'registrationSuccess'])->name('register.success');
});

// Public exam routes (for students to take exams)
Route::prefix('exams')->name('exams.')->group(function () {
    Route::get('/', function () {
        // Show list of available exams
        $exams = \App\Models\Exam::where('is_active', true)->get();
        return view('public.exams-list', compact('exams'));
    })->name('list');
    
    Route::get('/take/{examId}', UserExam::class)->name('take');
});

// Protected teacher routes
Route::middleware('auth:teacher')->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard', TeacherDashboard::class)->name('dashboard');
    Route::get('/students', StudentManagement::class)->name('students');
    Route::get('/classes', ClassManagement::class)->name('classes');
    Route::get('/reports', AttendanceReports::class)->name('reports');
    Route::get('/exams', ExamManagement::class)->name('exams');
    Route::get('/exam-results', ExamResultsManagement::class)->name('exam-results');
    Route::get('/download/export', [ExportController::class, 'downloadExport'])->name('download.export');
});
