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
            ->can(Permissions::$LIST_USERS)
            ->name('users.index');

        Route::get('users/{user}', [UserController::class, 'view'])
            ->can(Permissions::$VIEW_USERS)
            ->name('users.view');

        Route::get('users/{user}/edit', [UserController::class, 'edit'])
            ->can(Permissions::$VIEW_USERS)
            ->name('users.edit');

        Route::post('users/{user}', [UserController::class, 'update'])
            ->can(Permissions::$VIEW_USERS)
            ->name('users.update');
    });

