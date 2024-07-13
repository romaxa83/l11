<?php

use Illuminate\Support\Facades\Route;
use Modules\Blog\Controllers\BlogController;

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::apiResource('blog', BlogController::class)->names('blog');
});
