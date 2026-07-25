<?php

use App\Http\Controllers\Api\V1\Admin\SessionController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')
    ->middleware(['auth:sanctum'])
    ->group(function (): void {
        Route::get('/session', SessionController::class)
            ->name('api.v1.admin.session');
    });
