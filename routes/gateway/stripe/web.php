<?php

use App\Http\Controllers\Api\Gateway\Stripe\StripeCallBackController;
use Illuminate\Support\Facades\Route;


Route::controller(StripeCallBackController::class)->prefix('payment/stripe')->name('payment.stripe.')->group(function () {
    Route::get('/success', 'success')->name('success');
    Route::get('/cancel', 'failure')->name('cancel');
});