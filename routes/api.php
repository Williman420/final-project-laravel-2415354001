<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\CustomerController;

Route::apiResource('customers', CustomerController::class);

Route::patch(
    'customers/{customer}/activate',
    [CustomerController::class, 'activate']
);

Route::patch(
    'customers/{customer}/deactivate',
    [CustomerController::class, 'deactivate']
);
