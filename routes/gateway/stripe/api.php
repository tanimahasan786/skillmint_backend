<?php

use App\Http\Controllers\API\Gateway\Stripe\StripeCallBackController;
use App\Http\Controllers\API\Gateway\Stripe\StripeOnBoardingController;
use App\Http\Controllers\API\Gateway\Stripe\StripeSubscriptionsController;
use App\Http\Controllers\API\Gateway\Stripe\StripeWebHookController;
use App\Http\Controllers\API\Gateway\Stripe\StripeWebHookSplitController;
use Illuminate\Support\Facades\Route;

/*
# Stripe routes
*/

//stripe callback
Route::controller(StripeCallBackController::class)->prefix('payment/stripe')->name('payment.stripe.')->group(function () {
    Route::post('/checkout', 'checkout')->middleware(['auth:api']);
});

//stripe webhook
Route::controller(StripeWebHookController::class)->prefix('payment/stripe')->name('payment.stripe.')->group(function () {
    Route::post('/intent', 'intent')->middleware(['auth:api']);
    Route::post('/webhook', 'webhook');
});

//stripe split webhook
Route::controller(StripeWebHookSplitController::class)->prefix('payment/stripe/split')->name('payment.stripe.split.')->group(function () {
    Route::get('/intent/{booking_id}', 'intent')->name('intent');
    Route::post('/webhook', 'webhook')->name('webhook');
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

//stripe subscriptions
Route::controller(StripeSubscriptionsController::class)->prefix('payment/stripe/subscriptions')->name('payment.stripe.subscriptions.')->group(function () {
    Route::post('/plan', 'plan');
    Route::get('/my/plan', 'myPlan');
    Route::get('/cancel/plan', 'cancelPlan');
});
