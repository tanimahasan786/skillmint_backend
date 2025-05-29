<?php

use App\Http\Controllers\API\Gateway\Stripe\StripeOnBoardingController;
use App\Http\Controllers\API\Gateway\Stripe\StripeSpliteBookingWebHookController;
use Illuminate\Support\Facades\Route;

//stripe webhook
Route::controller(StripeSpliteBookingWebHookController::class)->prefix('student/course/booking/stripe/')->name('student.course.booking.stripe.')->group(function () {
    Route::post('/intent', 'intent')->middleware(['auth:api']);
    Route::post('/webhook', 'webhook');
});

//stripe account
Route::controller(StripeOnBoardingController::class)->prefix('payment/stripe/account')->name('payment.stripe.account.')->group(function () {
    Route::middleware(['auth:api'])->get('/connect', 'accountConnect')->name('connect');
    Route::get('/connect/success/{account_id}', 'accountSuccess')->name('connect.success');
    Route::get('/connect/refresh/{account_id}', 'accountRefresh')->name('connect.refresh');
    Route::middleware(['auth:api'])->get('/url', 'AccountUrl')->name('url');
    Route::middleware(['auth:api'])->get('/info', 'accountInfo')->name('info');
    Route::middleware(['auth:api'])->post('/withdraw', 'withdraw')->name('withdraw');
});

