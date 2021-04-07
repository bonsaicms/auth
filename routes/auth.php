<?php

use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Route;
use BonsaiCms\Auth\FetchUserResponseContract;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;

// Authentication...
$limiter = config('fortify.limiters.login');

Route::post('login', [AuthenticatedSessionController::class, 'store'])
    ->middleware(array_filter([
        'guest',
        $limiter ? 'throttle:'.$limiter : null,
    ]));

Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);

Route::middleware('auth:sanctum')->get('user', function () {
    return app(FetchUserResponseContract::class);
});

// Password Reset...
if (Features::enabled(Features::resetPasswords())) {
    Route::post('password/forgot', [PasswordResetLinkController::class, 'store'])->middleware('throttle:passwordForgot');
    Route::post('password/reset', [NewPasswordController::class, 'store']);
}
