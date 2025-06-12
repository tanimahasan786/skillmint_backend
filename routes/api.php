<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\FirebaseTokenController;

use App\Http\Controllers\API\Auth\UserController;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\LogoutController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Auth\SocialLoginController;
use App\Http\Controllers\API\Auth\ResetPasswordController;
use App\Http\Controllers\API\admin\TermsAndConditionController;

Route::group(['middleware' => 'guest:api'], static function () {
    //register
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('/verify-email', [RegisterController::class, 'VerifyEmail']);
    Route::post('/resend-otp', [RegisterController::class, 'ResendOtp']);
    //login
    Route::post('login', [LoginController::class, 'login']);
    //forgot password
    Route::post('/forget-password', [ResetPasswordController::class, 'forgotPassword']);
    Route::post('/verify-otp', [ResetPasswordController::class, 'VerifyOTP']);
    Route::post('/reset-password', [ResetPasswordController::class, 'ResetPassword']);
    //social login
    Route::post('/social-login', [SocialLoginController::class, 'SocialLogin']);
});

Route::group(['middleware' => 'auth:api'], static function () {
    Route::get('/refresh-token', [LoginController::class, 'refreshToken']);
    Route::post('/logout', [LogoutController::class, 'logout']);

    //Teacher Profile management
    Route::get('/teacher/profile', [UserController::class, 'TeacherProfile']);
    Route::post('/teacher/upload-avatar', [UserController::class, 'TeacherUploadAvatar']);
    Route::post('/teacher/update-profile', [UserController::class, 'TeacherUpdateProfile']);
    Route::delete('/teacher/delete-profile', [UserController::class, 'TeacherDeleteProfile']);
    Route::post('/change-password', [ResetPasswordController::class, 'teacherPasswordManager']);

    //Student Profile management
    Route::get('/student/profile', [UserController::class, 'StudentProfile']);
    Route::post('/student/upload-avatar', [UserController::class, 'StudentUploadAvatar']);
    Route::post('/student/update-profile', [UserController::class, 'StudentUpdateProfile']);
    Route::delete('/student/delete-profile', [UserController::class, 'StudentDeleteProfile']);

    Route::get('/terms-condition', [TermsAndConditionController::class, 'getTermsAndConditions'])->name('termsandCondition');
    Route::get('/privacy-policy', [TermsAndConditionController::class, 'getPrivacyPolicy'])->name('privacyPolicy');

    // Firebase Token Module
    Route::get("firebase/test", [FirebaseTokenController::class, 'test']);
    Route::post("firebase/token/create", [FirebaseTokenController::class, 'store']);
    Route::post("firebase/token/get", [FirebaseTokenController::class, "getToken"]);
    Route::post("firebase/token/delete", [FirebaseTokenController::class, "deleteToken"]);

    //Notification all route
    Route::get('notifications', [\App\Http\Controllers\API\Notification\NotificationController::class, 'getNotifications']);
});
