<?php

use App\Http\Controllers\API\Student\MyResourceController;
use Illuminate\Support\Facades\Route;


Route::controller(MyResourceController::class)->prefix('my-resources')->group(function () {
    Route::get('/', 'index');
});