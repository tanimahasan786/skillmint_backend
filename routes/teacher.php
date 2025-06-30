<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Teacher\CourseController;
use App\Http\Controllers\API\Teacher\CourseModuleController;
use App\Http\Controllers\API\Teacher\CurriculumController;
use App\Http\Controllers\API\Teacher\HomeController;
use App\Http\Controllers\API\Teacher\ResourceValueController;
use App\Http\Controllers\API\Teacher\ReviewController;
use App\Http\Controllers\API\Teacher\TeacherMentorController;
use App\Http\Controllers\API\Teacher\WithdrawRequestController;

//course related route
Route::controller(CourseController::class)->prefix('course')->group(function () {
    Route::get('/', 'view');
    Route::post('/create', 'create');
    Route::post('/update/{id}', 'update');
    Route::post('/delete/{id}', 'delete');
    Route::get('/get/categories', 'getCategories');
    Route::get('/get/grade-level', 'getGradeLevel');
    Route::post('/{id}/toggle-status', 'TogglePublished');
    Route::get('/enroll/course', 'myResource');
});

Route::controller(CourseModuleController::class)->prefix('course-module')->group(function () {
    Route::get('/', 'view');
    Route::post('/create', 'create');
    Route::post('/update/{moduleId}', 'update');
    Route::delete('/delete/{id}', 'delete');
});
//Teacher mentor all route
Route::controller(TeacherMentorController::class)->prefix('teacher-mentor')->group(function () {
    Route::get('/', 'index');
    Route::post('/create', 'create');
    Route::post('/update/{moduleId}', 'update');
    Route::delete('/delete/{id}', 'delete');
});

//Teacher mentor all route
Route::controller(CurriculumController::class)->prefix('course-curriculum')->group(function () {
    Route::get('/details/{curriculum}', 'details');
});

//Teacher review
Route::controller(ReviewController::class)->prefix('review')->group(function () {
    Route::get('/details', 'index');
    Route::post('/create/{id}', 'submitReview');
});

//Withdraw Request
Route::controller(WithdrawRequestController::class)->group(function () {
    Route::post('/withdraw-request', 'withdrawRequest');
    Route::get('/my-wallet', 'myWallet');
});

//Teacher Home Api
Route::controller(HomeController::class)->prefix('home')->group(function () {
    Route::get('/', 'index');
    Route::get('/filter-category', 'filterCategory');
    Route::get('/search-course', 'searchByCourse');
    Route::get('/sales', 'sales');
});

Route::middleware('onboarding')->controller(ResourceValueController::class)->prefix('home')->group(function () {
    Route::get('/resource/value', 'index');
    Route::get('/resource/performance/metrics', 'RevenueBreakdown');
    Route::get('/enroll/complete/breakdown', 'EnrollmentCompletionBreakdown');
    Route::get('/revenue/trade/growth', 'RevenueTrendsGrowthIndicator');
});

//enroll student list
/* Route::controller(CertificateController::class)->prefix('student')->group(function () {
    Route::get('/list/{course_id}', 'index');
    Route::post('/certificate', 'store');
}); */
