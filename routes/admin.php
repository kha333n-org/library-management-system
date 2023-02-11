<?php
/*
 * Copyright (c) 2023.
 * Usman Khan
 * GitHub: kha333n
 */


use App\Http\Controllers\Admin\Users\UserController;
use App\Utils\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->group(function () {
        Route::get('users', [UserController::class, 'index'])
            ->can(Permissions::$LIST_USERS);
    });

