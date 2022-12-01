<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\V1\Auth\VerifyEmailController;

Route::prefix('v1')
    ->as('v1.')
    ->group(function () {
        Auth::routes();
});