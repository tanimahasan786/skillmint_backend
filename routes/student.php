<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Student\CurriculumController;
use App\Http\Controllers\API\Student\EnrollController;
use App\Http\Controllers\API\Student\HomeController;
use App\Http\Controllers\API\Student\IsCompleteController;
use App\Http\Controllers\API\Student\MentorController;
use App\Http\Controllers\API\Student\MyResourceController;


Route::controller(MyResourceController::class)->prefix('my-resources')->group(function () {
    Route::get('/', 'index');
});

//Student home all route
Route::controller(HomeController::class)->prefix('home/student')->group(function () {
    Route::get('/', 'index');
    Route::get('/filter-category', 'filterCategory');
    Route::get('/search-course', 'searchByCourse');
});

//Student course booking all route
Route::controller(CurriculumController::class)->prefix('student/course-curriculum')->group(function () {
    Route::get('/details/{curriculum}', 'details');
});

//Student  mentor all route
Route::controller(MentorController::class)->prefix('student/teacher-mentor')->group(function () {
    Route::get('/{user_id}', 'index');
    Route::post('/create', 'create');
    Route::post('/update/{moduleId}', 'update');
    Route::delete('/delete/{id}', 'delete');
});

Route::post('/enroll', [EnrollController::class, 'enroll']);
Route::post('/is-complete', [IsCompleteController::class, 'isComplete']);
