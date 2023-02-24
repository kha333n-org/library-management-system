<?php
/*
 * Copyright (c) 2023.
 * Usman Khan
 * GitHub: kha333n
 */


use App\Http\Controllers\Admin\Roles\RolesController;
use App\Http\Controllers\Admin\Users\UserController;
use App\Utils\Permissions;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->group(function () {

        Route::resource('users', UserController::class);

        Route::get('users/roles/{user}', [UserController::class, 'viewRoles'])
            ->can(Permissions::$ALLOCATE_ROLES)
            ->name('users.roles');

        Route::put('users/roles/{user}', [UserController::class, 'updateRoles'])
            ->can(Permissions::$ALLOCATE_ROLES)
            ->name('users.roles.update');


        Route::resource('roles', RolesController::class);
    });

