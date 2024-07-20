<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Actions;

Route::middleware(['auth:sanctum'])
    ->prefix('v1')
    ->name('v1.')
    ->group(function () {
        Route::post('login', Actions\LoginUser::class)
            ->withoutMiddleware(['auth:sanctum'])
            ->name('login');

        Route::get('current-user', Actions\GetCurrentUserInfo::class)
            ->name('current-user');

        Route::post('logout', Actions\LogoutUser::class)
            ->name('logout');
    });
