<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\ServiceController;


Route::apiResource("services", ServiceController::class);
Route::patch("services/{service}/activate", [
    ServiceController::class,
    "activate",
]);
Route::patch("services/{service}/deactivate", [
    ServiceController::class,
    "deactivate",
]);
Route::apiResource('subscriptions', SubscriptionController::class)
    ->only([
        'index',
        'store',
        'show',
        'update'
    ]);
